<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Application;

class Installation
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $app;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Application $app, Guard $auth)
    {
        $this->auth = $auth;
        $this->app = $app;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$this->checkSetup()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            }else{
                $locale = $this->app->getLocale();
                return redirect()->action('SetupController@getIndex');
            }
        }

        return $next($request);
    }
    
    private function checkSetup()
    {
        $stmt= $this->getDBConnection()->prepare("SHOW DATABASES LIKE '".env('DB_DATABASE', 'homestead')."'");
        $stmt->execute();
        if($stmt->rowCount()==0){
            return FALSE;
        }
        return TRUE;
        
    }
    
    private function getDBConnection()
    {
        //$pdo = DB::connection()->getPdo();
        $pdo =  new \PDO("mysql:host=".env('DB_HOST','localhost'), env('DB_USERNAME','root'), env('DB_PASSWORD',''));
        return $pdo;
    }
}
