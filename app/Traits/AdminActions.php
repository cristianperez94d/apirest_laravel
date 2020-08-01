<?php
namespace App\Traits;

use App\User;


/**
 * Trait that implements in every policies
 */
trait AdminActions
{
  // Metodo que se ejecuta antes de las demas metodos del policy No es necesario llamaralo en el controllador
  public function before(User $user,$ability){

    if($user->admin === User::USER_ADMIN){
        return true;
    }

  }
}
