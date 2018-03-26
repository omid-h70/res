<?php

namespace App\Http\Controllers\Admin;
use App\Article ;
use App\Picture ;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Redirector;


class AdminController extends Controller {
    

    /*
    |--------------------------------------------------------------------------
    | Admin Controller
    |--------------------------------------------------------------------------
    |
    */   
    public function __construct(){
        $this->_namespace_slug = 'admin';
	parent::__construct();	
    }

    /*
     *
     */

    public function getIndex()
    {  
        //dd( auth()->check() );
        return view('admin.index');
    }

    public function getAdminProfile()
    {
            //
    }

}
?>