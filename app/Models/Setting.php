<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB ;

class Setting extends SuperClass
{
    /*
     * table_name and Primary Key
     */
    protected  $table = 'settings';
    protected  $primaryKey = 'setting_id';
    
    protected $fillable = [

    ];
    
    /*
     * 
     */
    function __construct(array $attributes = array())
    {
        // TODO - Insert your code here
        parent::__construct($attributes);
    }
    
    public function checkArticleExists($title)
    {
        
        $result = Article::select('title')
            ->where('article_title',$title)
            ->get()->ToArray();

        if ( is_array( $result) ){
             return $result;
        }else{
            return FALSE;
        }        
    }
    
    public function getAllSettings(array $options = NULL)
    {
        $setting_array = Setting::all()->toArray();
    	return $setting_array;
    }

    
   

}

