<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubcategoryResource extends JsonResource
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
            'foto' => $this->image,
            // 'categoria' => $this->category,
            'categoria' => $this->category_id,
            'links' => [
                'rel' => 'self',
                'href' => route('subcategories.show', $this->id)
            ]
        ];
    }

    public static function originalAttribute($index){
        $attributes = [
            'id' => 'identificador',
            'name' => 'nombre', 
            'image' => 'foto',
            'category_id' => 'categoria',
        ];
        $key = array_search($index, $attributes, true);
        return  $key;
    }

    public static function transformAttribute($index){
        
        $attributes = [
            'identificador' => 'id',
            'nombre' => 'name', 
            'foto' => 'image',
            'categoria' => 'category_id',
        ];
        $key = array_search($index, $attributes, true);
        return  $key;
    }


}
