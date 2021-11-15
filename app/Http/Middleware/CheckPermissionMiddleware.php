<?php

namespace App\Http\Middleware;

//use APP\Http\Traits\Responses;
use Illuminate\Http\Request;
use HttpResponse;
use Closure;

class CheckPermissionMiddleware
{
//    use Responses;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth('api')->user();
//        $userRoles = $user->role()->pluck('role-name')->toArray();
        $userRole = $user->role->role_name;



//        foreach($roles as $role){
            if(in_array( $userRole, $roles )){
//                return $this->gerErrors('unauthorized' , \HttpResponse::HTTP_FORBIDDEN);
                return response()->json('unauthorized' , 403);
            }
//        }

        return $next($request);
    }
}
