<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'image',
        'product_id'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
    
}
