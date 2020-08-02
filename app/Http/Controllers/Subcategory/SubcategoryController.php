<?php

namespace App\Http\Controllers\Subcategory;

use App\Category;
use App\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\SubcategoryResource;

class SubcategoryController extends ApiController
{
    public function __construct(){
        $this->middleware('auth:api')->except('index', 'show');
        $this->middleware('transform.input:'.SubcategoryResource::class)
            ->only(['store', 'update']);
        $this->middleware('can:storeSubcategory,App\Subcategory')->only('store');
        $this->middleware('can:updateSubcategory,subcategory')->only('update');
        $this->middleware('can:destroySubcategory,subcategory')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories = Subcategory::all();
        return $this->showAll($subcategories);
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
            'category_id' => ['required', 'integer'],
        ];

        $request->validate($reglas);

        $params = $request->all();

        Category::findOrFail($params['category_id']);
        $params['image'] = $request->image->store('img/subcategories');

        $subcategory = Subcategory::create($params);
        
        return $this->showOne($subcategory, 200, 'Subcategoria almacenada correctamente');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Subcategory $subcategory)
    {
        return $this->showOne($subcategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        $reglas = [
            'image' => ['image'],
            'category_id' => ['integer'],
        ];

        $request->validate($reglas);

        if($request->filled('name')){
            $subcategory->name = $request->name;
        }
        if($request->filled('image')){
            Storage::delete($subcategory->image);
            $subcategory->image = $request->image->store('img/subcategories');
        }
        if($request->filled('category_id')){
            if(!is_object(Category::find($request->category_id))){
                return $this->errorResponse('La categoria que trata de ingresar no existe', 404);
            }
            $subcategory->category_id = $request->category_id;
        }

        if(!$subcategory->isDirty()){
            return $this->errorResponse('Se debe especificar un valor diferente', 400);
        }
        
        // save subcategory
        $subcategory->save();

        return $this->showOne($subcategory, 200 , 'Registro actualizado correctamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subcategory $subcategory)
    {
        Storage::delete($subcategory->image);
        $subcategory->delete();

        return $this->showOne($subcategory, 200, 'Subcategoria eliminada correctamente');
    }
}
