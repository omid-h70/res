<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;

class CheckPermission
{
    protected $_app;
    
    public function __construct(Application $app){
        $this->_app = $app;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle( Request $request, Closure $next,  $permission = null)
    {
        $locale = $this->_app->getLocale();
        if (!app('Illuminate\Contracts\Auth\Guard')->guest()) {
            if ($request->user()->can($permission)) {
                return $next($request);
            }
            
        }
        
        return  $request->ajax() ? response('404',401) : redirect($locale.'/404');
    }
}
