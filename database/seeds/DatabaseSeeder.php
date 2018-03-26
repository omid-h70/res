<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
//use Seeds;

class DatabaseSeeder extends Seeder
{
    private $seederClasses;
    private $configFile = 'site.seederClasses';
    
    public function getSeederClasses(){
        return $this->seederClasses;
    }
    
    public function setSeederClasses($seederClasses){
        $this->seederClasses=$seederClasses;
    }
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();      
        $this->setSeederClasses(config($this->configFile));
        foreach( $this->getSeederClasses() as $class){
            $this->call($class);
        }
        Model::reguard();
    }
}
