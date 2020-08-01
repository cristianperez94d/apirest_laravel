<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'correo'=> $this->email, 
            'esAdministrador' => $this->admin,
            'links' => [
                'rel' => 'self',
                'href' => route('users.show', $this->id)
            ]
        ];
    }

    public static function originalAttribute($index){
        $attributes = [
            'id' => 'identificador',
            'name' => 'nombre', 
            'email' => 'correo', 
            'password' => 'contraseña',
            'password_confirmation' => 'confirmar_contraseña',
            'admin' => 'esAdministrador',
        ];
        $key = array_search($index, $attributes, true);
        return  $key;
    }

    public static function transformAttribute($index){
        $attributes = [
            'identificador' => 'id',
            'nombre' => 'name', 
            'correo' => 'email', 
            'contraseña' => 'password',
            'confirmar_contraseña' => 'password_confirmation',
            'esAdministrador' => 'admin',
        ];
        $key = array_search($index, $attributes, true);
        return  $key;
    }
}
