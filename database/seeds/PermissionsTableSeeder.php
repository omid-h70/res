<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Http\Controllers\Controller;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


/**
 * Description of ArticlesTableSeeder
 *
 * @author Omid
 */
class PermissionsTableSeeder extends Seeder{
   
    public  $configFile = 'site.registeredControllers';
    private $registeredClasses ;
    
    
    public function setRegisteredClasses($registeredClasses){
        $this->registeredClasses = $registeredClasses ;
    }
    
    public function getRegisteredClasses(){
        return $this->registeredClasses ;
    }
    
    public function run(){
        $this->setRegisteredClasses(config($this->configFile));
        $controller = new Controller();
        foreach( $this->getRegisteredClasses() as $class){
            //var_dump($class);
            $controller->setControllerAcl($class);
            
        }
        //dd();
    }
}
