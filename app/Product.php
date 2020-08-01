<?php

namespace App;

use App\Photo;
use App\Subcategory;
use App\Http\Resources\ProductResource;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\ProductCollection;

class Product extends Model
{
    public $resource = ProductResource::class;
    public $resourceCollection = ProductCollection::class;

    protected $fillable = [
        'name',
        'description',
        'weight',
        'price',
        'image',
        'subcategory_id'
    ];

    public function subcategory(){
        return $this->belongsTo(Subcategory::class);
    }

    public function photos(){
        return $this->hasMany(Photo::class);
    }
}
