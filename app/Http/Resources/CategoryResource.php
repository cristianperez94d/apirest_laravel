<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // $transform = SubcategoryResource::collection($this->Subcategories);    
    
        // $collection =  new SubcategoryCollection($transform);

        return [
            'identificador' => $this->id,
            'nombre' => $this->name,
            'foto' => $this->image,
            'links' => [
                'rel' => 'self',
                'href' => route('categories.show', $this->id)
            ]
        ];
    }

    public static function originalAttribute($index){
        $attributes = [
            'id' => 'identificador',
            'name' => 'nombre', 
            'image' => 'foto',
        ];
        $key = array_search($index, $attributes, true);
        return  $key;
    }

    public static function transformAttribute($index){
        
        $attributes = [
            'identificador' => 'id',
            'nombre' => 'name', 
            'foto' => 'image',
        ];
        $key = array_search($index, $attributes, true);
        return  $key;
    }


}
