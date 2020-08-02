<?php

namespace App;

use App\Product;
use App\Category;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\SubcategoryResource;
use App\Http\Resources\SubcategoryCollection;

class Subcategory extends Model
{
    public $resource = SubcategoryResource::class;
    public $resourceCollection = SubcategoryCollection::class;

    protected $fillable = [
        'name',
        'image',
        'category_id'
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}
