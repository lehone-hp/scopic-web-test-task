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

    public function category() {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
}
