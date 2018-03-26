<?php
namespace App\Models;


use Illuminate\Support\Facades\DB;

class Picture extends SuperClass
{
    public static $LABEL = 'picture'; 
    public static $NORMAL_TYPE = 'normal';  
      
    protected $table ='pictures';
    protected $primaryKey ='picture_id';

    protected $fillable = [
    	'user_id',
	'food_id',
	'article_id',
	'picture_slug',
	'picture_title',
	'picture_ext',
	'picture_type',
	'picture_status',
        
    ];
    // TODO - Insert your code here
    
    /*
     * 
     * 
     */
    
    public function getPictureBy( array $picture, $output = NULL ){

        $fields = array ('picture_id','picture_slug','food_id');
        $picture_array = array();

        foreach( $fields as $field ){
            
            if ( !empty($picture[$field]) ){
                
                switch( $field ){
                    
                    case'picture_id':
                        $pic_obj = Picture::firstOrNew(['picture_id' => $picture['picture_id'] ] );
                    break;
                    
                    case'picture_slug':
                        $pic_obj = Picture::firstOrNew(['picture_slug' => $picture['picture_slug'] ] );
                    break;
                
                    case'food_id':
                        $pic_obj = Picture::where('food_id' , $picture['food_id']  )->get();
                    break;
                    
                    
                }
            }
            
        }
        if( empty($output) || $output == 'array' ){
            
            $picture_array = $pic_obj->toArray();
            //var_dump($picture_array);
            return $picture_array;
            
        }elseif( $output =='object' ){        
            return $pic_obj;
        }
        
    }
    
     /**
     *  One To Many
     *  
     *
     * @return QueryBuilder Object
     */
    public function food()
    {
        return $this->belongsTo('App\Models\Food');
    }
     /**
     *  One To Many
     *  
     *
     * @return QueryBuilder Object
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
}

?>
