<?php

namespace App\Http\Controllers\Photo;

use App\Photo;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Resources\PhotoResource;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;

class PhotoController extends ApiController
{
    public function __construct(){
        $this->middleware('auth:api')->except('index', 'show');
        $this->middleware('transform.input:'.PhotoResource::class)
            ->only(['store', 'update']);
        $this->middleware('can:storePhoto,App\Photo')->only('store');
        $this->middleware('can:updatePhoto,photo')->only('update');
        $this->middleware('can:destroyPhoto,photo')->only('destroy');
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $photos = Photo::all(); 
        return $this->showAll($photos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reglas = [
            'image' => ['required', 'image'],
            'product_id' => ['required', 'integer'],
        ];

        $request->validate($reglas);

        $params = $request->all();

        $params['image'] = $request->image->store('img/products');

        Product::findOrFail($params['product_id']);

        $photo = Photo::create($params);
        
        return $this->showOne($photo, 200, 'Foto almacenado correctamente');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {   
        return $this->showOne($photo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {
        $reglas = [
            'image' => ['image'],
            'product_id' => ['integer'],
        ];

        $request->validate($reglas);

        if($request->filled('image')){
            Storage::delete($photo->image);
            $photo->image = $request->image->store('img/products');
        }
        if($request->filled('product_id')){
            Product::findOrFail($request->product_id);
            $photo->product_id = $request->product_id;
        }

        if(!$photo->isDirty()){
            return $this->errorResponse('Se debe especificar un valor diferente', 400);
        }
        
        // save product
        $photo->save();

        return $this->showOne($photo, 200 , 'Registro actualizado correctamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        Storage::delete($photo->image);
        $photo->delete();

        return $this->showOne($photo, 200, 'Fotografia eliminada correctamente');
    }
}
