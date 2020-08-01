<?php

namespace App;

use App\Product;
use App\Http\Resources\PhotoResource;
use App\Http\Resources\PhotoCollection;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    public $resource = PhotoResource::class;
    public $resourceCollection = PhotoCollection::class;


    protected $fillable = [
        'image',
        'product_id'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
    
}
