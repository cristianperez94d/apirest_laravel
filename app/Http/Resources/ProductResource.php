<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'identificador' => $this->id,
            'nombre' => $this->name,
            'descripcion' => $this->description,
            'peso' => $this->weight,
            'precio' => $this->price,
            'foto' => $this->image,
            'subcategoria' => $this->subcategory_id,
            'links' => [
                'rel' => 'self',
                'href' => route('products.show', $this->id)
            ]
        ];
    }

    public static function originalAttribute($index){
        $attributes = [
            'id' => 'identificador',
            'name' => 'nombre', 
            'description' => 'descripcion', 
            'weight' => 'peso',
            'price' => 'precio',
            'image' => 'foto',
            'subcategory_id' => 'subcategoria',
        ];
        $key = array_search($index, $attributes, true);
        return  $key;
    }

    public static function transformAttribute($index){
        
        $attributes = [
            'identificador' => 'id',
            'nombre' => 'name', 
            'descripcion' => 'description', 
            'peso' => 'weight',
            'precio' => 'price',
            'foto' => 'image',
            'subcategoria' => 'subcategory_id',
        ];
        $key = array_search($index, $attributes, true);
        return  $key;
    }


}
