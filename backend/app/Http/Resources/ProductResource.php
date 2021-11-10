<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'min_bid' => $this->min_bid,
            'highest_bid' => $this->highestBid() ? $this->highestBid()->amount : 0,
            'category' => $this->category->name,
            'close_date' => [
                'date' => $this->close_date,
                'timezone' => config('app.timezone')
            ],
            'image' => $this->image,
            'short_desc' => Str::limit(strip_tags($this->description), 100),
            'description' => $this->description
        ];
    }
}
