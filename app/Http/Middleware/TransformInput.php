<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Validation\ValidationException;

class TransformInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $resource)
    {
        $array = [];
        foreach ($request->all() as $input => $value) {
            $array[$resource::originalAttribute($input)] = $value;
        }
        $request->replace($array);
        
        $response = $next($request);
        
        // transformed the response in case validation exception  
        if( isset($response->exception) && $response->exception instanceof ValidationException){
            $errors = $response->getData()->error;
        
            $transformedErrors = [];

            foreach ($errors as $field => $error) {

                $transformedField = $resource::transformAttribute($field);
                $transformedErrors[$transformedField] = str_replace($field, $transformedField, $error);
            }
            
            $errors = $transformedErrors;

            $response->setData(["error" => $errors]);
        }

        return $response;
    }
}
