<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $warning = '';
        if ($this->auto_bid_reserve) {
            if ($this->user->reservePercentage() >= $this->auto_bid_reserve) {
                $warning = 'You have used up to '.$this->auto_bid_reserve.'% of reserved bids.';
            }
        }


        return [
            'user_id' => $this->user_id,
            'max_auto_bid' => $this->max_auto_bid,
            'auto_bid_reserve' => $this->auto_bid_reserve,
            'warning' => $warning
        ];
    }
}
