<?php

use App\User;
use App\Photo;
use App\Product;
use App\Category;
use App\Subcategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    
        Schema::disableForeignKeyConstraints();

        User::truncate();
        Category::truncate();
        Subcategory::truncate();
        Product::truncate();
        Photo::truncate();

        // Evitar que se disparen eventos de los modelos cuando se creen instancias de estos al correr los seed
        User::flushEventListeners();
        Category::flushEventListeners();
        Subcategory::flushEventListeners();
        Product::flushEventListeners();
        Photo::flushEventListeners();

        $cantUsers = 10;
        $cantCategories = 5;
        $cantSubcategories = 10;
        $cantProducts = 200;
        $canPhotos = 200;

        factory(User::class, $cantUsers)->create();
        factory(Category::class, $cantCategories)->create();
        factory(Subcategory::class, $cantSubcategories)->create();
        factory(Product::class, $cantProducts)->create();
        factory(Photo::class, $canPhotos)->create();

    }
}
