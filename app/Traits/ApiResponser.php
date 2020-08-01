<?php
namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * 
 */
trait ApiResponser
{
  private function successResponse($data, $code){
    return response()->json($data, $code);
  }

  protected function errorResponse($message, $code){
    return response()->json(['error' => $message], $code);
  }

  // return all elemetns of a collection
  protected function showAll(Collection $collection , $code = 200){
    $resource = $collection->first()->resource;
    $resourceCollection = $collection->first()->resourceCollection;        
  
    $collection = $this->transformCollection($collection, $resource, $resourceCollection);

    $collection = $this->paginate($collection);

    return $this->successResponse($collection, $code);
  }

  // return one element
  protected function showOne(Model $model , $code = 200, $message = 'ok'){
    $resource = $model->resource;
    $model = $this->transformModel($model, $resource);

    return $this->successResponse(['data'=>$model, 'success' => $message], $code);
  }

  // transformation of model with resource
  private function transformModel(Model $model, $resource){
    $transform =  new $resource($model);

    return $transform;
  }

  // transformero of collections with resource
  private function transformCollection(Collection $collection, $resource, $resourceCollection){
    $transform = $resource::collection($collection);    
    
    return new $resourceCollection($transform);
  }

  protected function paginate($collection){
    $rules = [
      'per_page' => ['integer', 'min:2', 'max:50']
    ];

    request()->validate($rules);

    $page = LengthAwarePaginator::resolveCurrentPage();

    $perPage = 5;
    if(request()->has('per_page')){
      $perPage = (int) request()->per_page;
    }

    $results = $collection->slice( ($page-1) * $perPage, $perPage )->values();

    $paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
      'path' => LengthAwarePaginator::resolveCurrentPath()
    ]);
    
    // Agregar la lista de parametros para ser ordenados porque LengthAwarePaginator elimina todos los parametros por defecto
    $paginated->appends( request()->all() );
    
    return $paginated;
  }


}

