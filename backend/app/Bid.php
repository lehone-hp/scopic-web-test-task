<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $fillable = ['user_id', 'product_id', 'amount', 'auto_bid'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
