<?php

namespace App\Models;



class Food extends SuperClass 
{   
    public static $LABEL = 'food' ;	
    protected $table ='foods';
    protected $primaryKey = 'food_id';
    //protected $fillable = ['food_id','food_slug','food_title'];
    //protected $guarded = ['user_id','price','status'];
    
    /***
	* 
        *   
    */ 
    public function getFoodById( $food_id ){

    	$food_array = Food::firstOrNew(['food_id' => $food_id ])
    	   ->toArray();

	return $food_array ;
    }

    public function getFoodCategories( $food_id ){

        $category_array = array();
    	$food = Food::find($food_id);
    	foreach( $food->categories as $category ){
    	   $category_array[$food_id][] = $category->toArray() ;	
    	}
        return $category_array;
    }
    
    public function getFoodTags( $food_id ){

        $tag_array = array();
    	$food = Food::find($food_id);
    	foreach( $food->tags as $tag ){
    	   $tag_array[$food_id][] = $tag->toArray() ;
    	   //$tag_object_array[] = $tag ;	
    	}
        return $tag_array;
    }

    public function getFoodTimes( $food_id ){

        $time_array = array();
    	$food = Food::find($food_id);
    	foreach( $food->times as $time ){
    	   $time_array[$food_id][] = $time->toArray() ;	
    	}
        return $time_array;
    }

    public function getAllFoods( array $options = NULL )
    {
        
        $fields = array ('limit');
        $food_array = array();
        
        foreach( $fields as $field ){
            
            if ( !empty($options[$field]) ){
                switch( $field ){
                    case'limit':
                        $food_array = Food::where('food_status',self::$NORMAL_STATUS)
                            ->limit($options[$field])->orderBy($this->primaryKey, 'desc')
                            ->get()->toArray();   
                    break;        
                }
            }else{
                $food_array = Food::all()->toArray();
            }
            
        }

    	return $food_array;
    }

    public function getFoodPictures( $food_id )
    {
        
        $pic_array = array();
    	$food = Food::find($food_id);
    	foreach( $food->pictures as $picture ){
    	   $pic_array[$food_id][] = $picture->toArray() ;	
    	}
        return $pic_array;
        
    }

    public function sample(){
	
	$food_array = Food::all();
	
    	foreach( $food_array as $key => $food ){
             echo $food->food_id ; 
             $temp = Food::find($food->food_id);
             foreach( $temp->tags as $tag ){
                   $test_array[] = $tag ;	
             }
    	}
    	return $test_array;
    }
    /*
     |--------------------------------------------------------------------------
     | Relationship Methods
     |--------------------------------------------------------------------------
     */


    /**
     *  Many-To-One Relationship Method for Accessing the 
     *  Each food Can have One Category or more Categories 
     *
     * @return QueryBuilder Object
     */
    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }
    /**
     *  Many-To-One Relationship Method for Accessing the
     *  Each food Can have One Category or more Categories
     *
     * @return QueryBuilder Object
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    /**
     *  One To Many
     *  
     *
     * @return QueryBuilder Object
     */
    public function pictures()
    {
        return $this->hasMany('App\Models\Picture');
    }
    /**
     *  Many To Many
     *
     *
     * @return QueryBuilder Object
     */
    public function times()
    {
        return $this->belongsToMany('App\Models\Time');
    }
    /**
     *  Many To Many
     *
     *
     * @return QueryBuilder Object
     */
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag');
    }
}
