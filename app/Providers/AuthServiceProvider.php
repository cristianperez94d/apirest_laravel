<?php

namespace App\Providers;

use App\User;
use App\Photo;
use App\Product;
use App\Category;
use App\Subcategory;
use App\Policies\UserPolicy;
use App\Policies\PhotoPolicy;
use Laravel\Passport\Passport;
use App\Policies\ProductPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\SubcategoryPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Product::class => ProductPolicy::class,
        Photo::class => PhotoPolicy::class,
        Category::class => CategoryPolicy::class,
        Subcategory::class => SubcategoryPolicy::class,                
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes( function ($router){
            $router->forAccessTokens();
        });

        Passport::tokensExpireIn(now()->addDays(1));
        Passport::refreshTokensExpireIn(now()->addDays(30));

    }

}
