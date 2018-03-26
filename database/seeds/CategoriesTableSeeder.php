<?php

use App\Models\Category;
use App\Models\Food;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;



class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Guarded Assignment
         * Specifying fiels one by one 
         * $guarded
         */
        $food_category_1 = array( 
            
            'category_title'  => 'غذای روزانه',
            'category_slug'   => 'غذای روزانه',
            'category_type'   => 'food',
            'user_id'         => 1 ,
            'category_status' => 'active'
            
        );
        
        $food_category_2 = array( 
            
            'category_title'  => 'دسر',
            'category_slug'   => 'دسر',
            'category_type'   => 'food',
            'user_id'         =>  1 ,
            'category_status' => 'active'
            
        );
        
        $food_category_3 = array( 
            
            'category_title'  => 'نوشیدنی',
            'category_slug'   => 'نوشیدنی',
            'category_type'   => 'food',
            'user_id'         => 1 ,
            'category_status' => 'active'
            
        );
        
        //++++++++++++++++++++++++++++++++++++++++++
        
        $page_category = array(
            
            'category_title'  => 'Page',
            'category_slug'   => 'page',
            'category_type'   => 'page',
            'user_id'         => 1 ,
            'category_status' => 'active'
            
        );
        

        $seed_array= array (
            $food_category_1, 
            $food_category_2, 
            $food_category_3, 
            $page_category 
            
        );

        foreach ($seed_array as $key => $category_array ){
    
            Category::create( $category_array  );

        }
        

    }
    
    ////
}