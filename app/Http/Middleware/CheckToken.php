<?php

namespace App\Http\Middleware;
use App\User;
use Closure;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token=$request->input('token');
        if($token)
        {
            $user=User::where('token','=',$token);
            if($user->count())

                return $next($request);
            else
            { 
              $errors[]=[
                'title' => 'Invalid Token',
                ];
            return  response([
                'errors' => $errors,
                'status' => 401,
                ]);
            }
        }
        else
        {
            $errors[]=[
                'title' => 'Token Missing',
                ];
            return  response([
                'errors' => $errors,
                'status' => 400,
                ]);
        }
    }
}