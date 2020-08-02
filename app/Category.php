<?php

namespace App;

use App\Subcategory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;

class Category extends Model
{
    public $resource = CategoryResource::class;
    public $resourceCollection = CategoryCollection::class;

    protected $fillable = [
        'name',
        'image'
    ];

    public function Subcategories(){
        return $this->hasMany(Subcategory::class);
    }
}
