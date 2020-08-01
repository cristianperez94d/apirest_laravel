<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Http\Controllers\ApiController;

class UserController extends ApiController
{
    public function __construct (){
        
        $this->middleware('auth:api')->except('store');
        $this->middleware('transform.input:'.UserResource::class)
            ->only(['store', 'update']);
        
        //  Policies
        $this->middleware('can:indexUser,App\User')->only('index');
        $this->middleware('can:showUser,user')->only('show');
        $this->middleware('can:updateUser,user')->only('update');
        $this->middleware('can:destroyUser,user')->only('destroy');
        
    }

    public function userData(){
        return $this->showOne(request()->user());
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return $this->showAll($users);
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
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6', 'confirmed'],
        ];

        $request->validate($reglas);
        
        $params = $request->all();

        // allow insert only one administrator
        if(User::all()->count() === 0){
            $params['admin'] = User::USER_ADMIN;    
        }else{
            $params['admin'] = User::USER_REGULAR;
        }

        $params['password'] = password_hash($params['password'],PASSWORD_DEFAULT);

        $user = User::create($params);

        return $this->showOne($user, 201, 'Usuario alamcenado correctamente');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->showOne($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $reglas = [
            'email' => ['email'],
            'password' => ['min:6', 'confirmed'],
        ];

        $request->validate($reglas);

        if($request->filled('name')){
            $user->name = $request->name;
        }
        if($request->filled('email')){
            $user->email = $request->email;
        }
        if($request->filled('password')){
            $user->password = $request->password;
        }

        if(!$user->isDirty()){
            return $this->errorResponse('Se debe especificar un valor diferente', 400);
        }

        $user->save();

        return $this->showOne($user, 200 , 'Registro actualizado correctamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return $this->showOne($user, 200, 'Registro eliminado correctamente');
    }
}
