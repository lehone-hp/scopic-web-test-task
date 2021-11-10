<?php

namespace App\Http\Controllers\API;

use App\Bid;
use App\Events\BidPlaced;
use App\Http\Controllers\Controller;
use App\Http\Resources\BidResource;
use App\Http\Resources\ProductResource;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BidController extends Controller
{
    public function placeBid(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'amount' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        $user = User::find($request->get('user_id'));
        $product = Product::find($request->get('product_id'));
        $highest_bid = $product->highestBid();
        $bid_amount = $request->get('amount');

        // check if bid is less than product's minimum bid
        if ($bid_amount < $product->min_bid) {
            return response()->json([
                'status' => 'error',
                'message' => 'The minimum allowed bid is $' . $product->min_bid
            ]);
        }

        // check if bid is less than or equal to the highest bid
        if ($highest_bid && $bid_amount <= $highest_bid->amount) {
            return response()->json([
                'status' => 'error',
                'message' => 'You can only place a bid higher than the last bid ($' . $highest_bid->amount . ')'
            ]);
        }

        $product->placeBid($user, $bid_amount);

        event(new BidPlaced($product));

        return response()->json([
            'status' => 'success',
            'message' => 'Big placed successfully',
            'product' => new ProductResource($product)
        ]);
    }

    public function toggleAutoBid(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        $user = User::find($request->get('user_id'));
        $product = Product::find($request->get('product_id'));

        $bid = Bid::where('user_id', $user->id)->where('product_id', $product->id)->first();

        // if auto-bidding is active, deactivate
        if ($bid && $bid->auto_bid) {
            $bid->update(['auto_bid' => false]);
            return response()->json([
                'status' => 'success',
                'message' => 'Auto bidding has been turned off for this product',
                'bid' => new BidResource($bid)
            ]);
        } else {
            // activate auto-bidding for this product
            $highest_bid = $product->highestBid();

            // check if there it atleast one bid for this product
            if (!$highest_bid) {
                $bid = $product->placeBid($user, $product->min_bid);
            } else {
                if ($highest_bid->user_id == $user->id) {
                    $bid = $highest_bid;
                } else if ($user->availableReserveAmt() > $highest_bid->amount) {
                    // check if user has enough reserve bid then highest bid by 1
                    $bid = $product->placeBid($user, $highest_bid->amount + 1);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Sorry, you do not have enough reserve for auto-bidding',
                    ]);
                }
            }

            $bid->update(['auto_bid' => true]);
            return response()->json([
                'status' => 'success',
                'message' => 'Auto bidding has been activated for this product',
                'bid' => new BidResource($bid),
                'product' => new ProductResource($product)
            ]);
        }
    }

    public function fetchBid(Request $request)
    {
        $bid = Bid::where('user_id', $request->get('user_id'))
            ->where('product_id', $request->get('product_id'))->first();
        return $bid ? new BidResource($bid) : [];
    }
}
