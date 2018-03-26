<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article ;
use App\Models\Food ;
use App\Models\Picture ;
use Illuminate\Support\Facades\App;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Redirector;


class IndexController extends Controller
{
    //
    public function __construct()
    {
       parent::__construct();
    }
    
//    public function index(){
//        dd('i\'m index ');
//        return view('setup');
//    }
//    
    public function index()
    {   	
        
        $article_obj = new Article();
        $food_obj = new Food();
        $picture_obj = new Picture();
        
        $article_array = $img_array = $food_array = $tag_array = $picture_array = $food_tag_array = array();
        $food_picture_array = array();
        
        
        $article_array = $article_obj->getAllArticles(['limit'=>3]);
        //dd($article_array);
        
        if( !empty($article_array) ){
            
            foreach( $article_array as $article_key => $article ){

               $article['article_body'] = htmlspecialchars_decode( $article['article_body'] );

               $doc = new \DOMDocument();
               $doc->loadHtml( $article['article_body'] );
               $img_array = $doc->getElementsByTagName('img');

               foreach( $img_array as $key => $img ){

                   $src = $img->getAttribute('src');
                   $article_array[$article_key]['img_array'][] = $src;

               }
        
            }
            
        }
       
        $food_array = $food_obj->getAllFoods( ['limit'=>4] );
        
        if( !empty($food_array) ){
            
            foreach( $food_array as $food ){
                $tag_array     = $food_obj->getFoodTags( $food['food_id'] ); 
                $picture_array[$food['food_id']] = $picture_obj->getPictureBy( array('food_id'=>$food['food_id']) );  
            }
            
            $food_tag_array     = $tag_array ;
            $food_picture_array = $picture_array;
            
        }
        //dd( $food_picture_array );
        //dd( $food_tag_array );
        
    	return view( 'index' )->with([
            'article_array'     => $article_array,
            'food_array'        => $food_array,
            'food_tag_array'    => $food_tag_array,
            'food_picture_array'=> $food_picture_array
        ]);
    }
    
    public function index2(){   //Test	
    	return view( 'index2' );
    }
    
    public function index3(){   //Test	
    	return view( 'index2' );
    }
    
    public function get404(){
        return view('404');
    }
    
    public function post404(){
        return view('404');
    }
}
