<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Photo;
use App\Product;
use App\Category;
use App\Subcategory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => password_hash('123456',PASSWORD_DEFAULT),
        'admin' => $faker->randomElement([User::USER_ADMIN, User::USER_REGULAR]),
        'remember_token' => Str::random(10),
    ];
});

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->word.'_category',
        'image' => $faker->randomElement(['img/categories/cat1.jpg','img/categories/cat2.jpg']),
    ];
});

$factory->define(Subcategory::class, function (Faker $faker) {
    return [
        'name' => $faker->word.'_Subcategory',
        'image' => $faker->randomElement(['img/subcategories/sub1.jpg','img/subcategories/sub2.jpg']),
        'category_id' => Category::all()->random()->id,
    ];
});

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word.'_product',
        'description' => $faker->paragraph(1),
        'weight' => $faker->randomNumber(3),
        'price' => $faker->randomNumber(3),
        'image' => $faker->randomElement(['img/products/pro1', 'img/products/pro2', 'img/products/pro3']),
        'subcategory_id' => Subcategory::all()->random()->id,
    ];
});

$factory->define(Photo::class, function (Faker $faker) {
    return [
        'image' => $faker->randomElement(['img/products/pro1', 'img/products/pro2', 'img/products/pro3']),
        'product_id' => Product::all()->random()->id,
    ];
});