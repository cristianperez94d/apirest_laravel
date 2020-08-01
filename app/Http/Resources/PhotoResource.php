<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PhotoResource extends JsonResource
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
            'foto' => $this->image,
            'producto' => $this->product_id,
            'links' => [
                'rel' => 'self',
                'href' => route('photos.show', $this->id)
            ]
        ];
    }
    public static function originalAttribute($index){
        $attributes = [
            'id' => 'identificador',
            'image' => 'foto', 
            'product_id' => 'producto',
        ];
        $key = array_search($index, $attributes, true);
        return  $key;
    }

    public static function transformAttribute($index){
        
        $attributes = [
             'identificador' => 'id',
             'foto' => 'image', 
             'producto' => 'product_id',
        ];
        $key = array_search($index, $attributes, true);
        return  $key;
    }

}