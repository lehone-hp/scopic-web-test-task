<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'min_bid',
        'category_id',
        'close_date',
        'image',
        'description'];

    // Relationships
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class, 'product_id');
    }

    // End Relationships


    public function highestBid()
    {
        return $this->bids()->orderBy('amount', 'DESC')->first();
    }

    public function placeBid(User $user, $amount)
    {
        // update existing bid for this user or create a new one
        $bid = Bid::updateOrCreate(
            [
                'user_id' => $user->id,
                'product_id' => $this->id],
            [
                'amount' => $amount
            ]);

        // Todo: dispatch runAutoBidEvent

        return $bid;
    }
}
