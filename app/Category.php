<?php

namespace App;

use App\Subcategory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'image'
    ];

    public function Subcategories(){
        return $this->hasMany(Subcategory::class);
    }
}
