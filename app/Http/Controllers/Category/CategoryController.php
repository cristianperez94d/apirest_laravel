<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CategoryResource;

class CategoryController extends ApiController
{
    public function __construct(){
        $this->middleware('auth:api')->except('index', 'show');
        $this->middleware('transform.input:'.CategoryResource::class)
            ->only(['store', 'update']);
        $this->middleware('can:storeCategory,App\Category')->only('store');
        $this->middleware('can:updateCategory,category')->only('update');
        $this->middleware('can:destroyCategory,category')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return $this->showAll($categories);
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
            'image' => ['required', 'image'],
        ];

        $request->validate($reglas);

        $params = $request->all();

        $params['image'] = $request->image->store('img/categories');

        $category = Category::create($params);
        
        return $this->showOne($category, 200, 'Categoria almacenada correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $this->showOne($category);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $reglas = [
            'image' => ['image'],
        ];

        $request->validate($reglas);

        if($request->filled('name')){
            $category->name = $request->name;
        }

        if($request->filled('image')){
            Storage::delete($category->image);
            $category->image = $request->image->store('img/categories');
        }

        if(!$category->isDirty()){
            return $this->errorResponse('Se debe especificar un valor diferente', 400);
        }
        
        // save category
        $category->save();

        return $this->showOne($category, 200 , 'Registro actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        Storage::delete($category->image);
        $category->delete();

        return $this->showOne($category, 200, 'categoria eliminada correctamente');
    }
}
