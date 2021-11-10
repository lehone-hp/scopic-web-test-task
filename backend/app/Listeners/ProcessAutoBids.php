<?php

namespace App\Listeners;

use App\Events\BidPlaced;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProcessAutoBids implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BidPlaced  $event
     * @return void
     */
    public function handle(BidPlaced $event)
    {
        // handle auto-bidding
        do {
            $product = $event->product;

            // sentinel to help us exit the loop when no user is able to out-bid
            $check = false;

            // get all users who have auto-bid active for this product
            $auto_bids = $product->bids()->where('auto_bid', true)
                ->whereHas('user', function ($q) {
                    $q->whereHas('setting', function ($q2) {
                        $q2->where('max_auto_bid', '>', 0);
                    });
                })->orderBy('created_at', 'ASC')->get();

            foreach ($auto_bids as $auto_bid) {
                $highest_bid = $product->highestBid();
                // check if the user has enough reserve
                if ($highest_bid->user_id != $auto_bid->user_id &&
                    $auto_bid->user->availableReserveAmt() > $highest_bid->amount) {

                    $product->placeBid($auto_bid->user, $highest_bid->amount + 1);
                    $check = true;

                }
            }
        } while ($check == true);
    }
}
