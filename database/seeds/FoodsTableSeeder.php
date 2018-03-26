<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


/**
 * Description of ArticlesTableSeeder
 *
 * @author Omid
 */

class FoodsTableSeeder extends Seeder{
    //put your code here
    
    public function run()
    {
        $sample_food_array = array(            
            
            'user_id'         => 1 ,
            'food_title'      =>'دیزی سنگی',
            'food_slug'       => 'دیزی_سنگی',
            'food_price'      => 1,           
            'food_status'     => 'normal',        
        );
        
        Food::create( $sample_food_array );
    }
}
