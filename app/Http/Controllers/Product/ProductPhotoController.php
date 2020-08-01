<?php

namespace App\Http\Controllers\Product;

use App\Photo;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Resources\PhotoResource;
use App\Http\Controllers\ApiController;

class ProductPhotoController extends ApiController
{
    public function __construct(){
        $this->middleware('auth:api')->except('index');
        $this->middleware('transform.input:'.PhotoResource::class)
            ->only(['store', 'update']);
        $this->middleware('can:storePhoto,App\Photo')->only('store');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $photos = $product->photos;
        return $this->showAll($photos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $reglas = [
            'image' => ['required', 'image'],
        ];

        $request->validate($reglas);

        $params = $request->all();

        $params['image'] = $request->image->store('img/products');
        $params['product_id'] = $product->id;
        
        $photo = Photo::create($params);
        
        return $this->showOne($photo, 200, 'Foto almacenado correctamente');

    }


}


