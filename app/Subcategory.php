<?php

namespace App;

use App\Product;
use App\Category;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
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
