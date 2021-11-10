<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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

        $bid = $product->placeBid($user, $bid_amount);

        return response()->json([
            'status' => 'success',
            'message' => 'Big placed successfully',
            'product' => new ProductResource($product)
        ]);
    }
}
