<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Artisan;

/**
 * Description of SetupController
 *
 * @author Omid
 */
class SetupController extends Controller{
    //put your code here
    
    public function __construct(Request $request){
        $this->_request = $request;
        //parent::__construct();
    }
    
    private function getDBConnection(){
        //$pdo = DB::connection()->getPdo();
        $pdo =  new \PDO("mysql:host=".env('DB_HOST','localhost'), env('DB_USERNAME','root'), env('DB_PASSWORD',''));
        return $pdo;
    }
        
    public function getIndex(){
        //dd($this->checkSetup());
        if($this->checkSetup()) {
            return redirect(App::getLocale().'/');
        }
        return view('setup');
        
    }
    
    public function postIndex(){
        
        if( $this->_request->ajax() ) {

            $input_params = $this->_request->all();
            $action = $input_params['action'];
            $response = '';

            switch($action){
                
                case 'create_db':
                    $result = $this->createDatabase();
                break;
                
                case 'db_seed':
                    $result = $this->seedDatabase();
                break;
            
                case 'create_migration':
                    $result = $this->createMigrationTable();
                break;
            }
            
            if($result || $result==0){
                $response = [
                    'no-error'  => trans('admin.done'),
                ];
    
            }
            return response()->json( $response );
        }else{
            if($this->checkSetup()) {
                return redirect(App::getLocale().'/');
            }
        }    
    }
    
    public function createDatabase(){
        
        $stmt= $this->getDBConnection()->prepare("CREATE DATABASE IF NOT EXISTS `".env('DB_DATABASE', 'homestead')."`");
        $stmt->execute();
        if($stmt->rowCount()==0){
            return FALSE;
        }
        return TRUE;

    }
    
    public function createMigrationTable(){
        return Artisan::call('migrate');
    }
    
    public function seedDatabase(){
        return Artisan::call('db:seed');
        
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
   
}
