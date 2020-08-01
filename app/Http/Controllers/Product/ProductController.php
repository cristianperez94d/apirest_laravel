<?php

namespace App\Http\Controllers\Product;

use App\Product;
use App\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;

class ProductController extends ApiController
{
    public function __construct(){
        $this->middleware('auth:api')->except('index', 'show');
        $this->middleware('transform.input:'.ProductResource::class)
            ->only(['store', 'update']);

        // Policies
        $this->middleware('can:storeProduct,App\Product')->only('store');
        $this->middleware('can:updateProduct,product')->only('update');
        $this->middleware('can:destroyProduct,product')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::All();
        return $this->showAll($products);
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
            'name' => ['required'],
            'description' => ['required','max:191'],
            'weight' => ['required','integer'],
            'price' => ['required','integer'],
            'image' => ['required', 'image'],
            'subcategory_id' => ['required', 'integer'],
        ];

        $request->validate($reglas);

        $params = $request->all();

        $params['image'] = $request->image->store('img/products');

        $product = Product::create($params);
        
        return $this->showOne($product, 200, 'Producto almacenado correctamente');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $this->showOne($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $reglas = [
            'description' => ['max:191'],
            'weight' => ['integer'],
            'price' => ['integer'],
            'image' => ['image'],
            'subcategory_id' => ['integer'],
        ];

        $request->validate($reglas);

        if($request->filled('name')){
            $product->name = $request->name;
        }
        if($request->filled('description')){
            $product->description = $request->description;
        }
        if($request->filled('weight')){
            $product->weight = $request->weight;
        }
        if($request->filled('price')){
            $product->price = $request->price;
        }
        if($request->filled('image')){
            Storage::delete($product->image);
            $product->image = $request->image->store('img/products');
        }
        if($request->filled('subcategory_id')){
            if(!is_object(Subcategory::find($request->subcategory_id))){
                return $this->errorResponse('La subcategoria que trata de ingresar no existe', 404);
            }
            $product->subcategory_id = $request->subcategory_id;
        }

        if(!$product->isDirty()){
            return $this->errorResponse('Se debe especificar un valor diferente', 400);
        }
        
        // save product
        $product->save();

        return $this->showOne($product, 200 , 'Registro actualizado correctamente');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        Storage::delete($product->image);
        $product->delete();

        return $this->showOne($product, 200, 'Producto eliminado correctamente');
    }
}
