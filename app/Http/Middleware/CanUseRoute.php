<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Permission;
use Illuminate\Http\Request;

class CanUseRoute
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
        $user =  $request->user() ?? auth('api')->user();
        
        if(!empty($request->route()[1]["as"])){
            $routeName=$request->route()[1]["as"];
            $permission = 'route:' . $routeName;
            if ($user->hasRole('administrator') || $user->can($permission) || $user->hasPermission($permission)) {
                return $next($request);
            }
    
            if (Permission::where('slug', $permission)->first()->is_hidden ?? false) {
                return $next($request);
            }
            
        }
        abort(403);

    }
}
