<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB ;

/**
 *
 * @author Omid
 *        
 */
class Category extends Model
{
    // TODO - Insert your code here
    protected $table ='categories'; 
    protected $primaryKey = 'category_id';
    
    protected $fillable = [
        'category_title',
        'category_slug',
        'category_status',
        'category_type'
     ];
    /**
     */
    function __construct( array $attributes = array() )
    {
        // TODO - Insert your code here
        parent::__construct($attributes);
    }
    
    public function getCategoryBy( array $category, $output = NULL ){

        $fields = array ('category_id','category_slug');
        $category_array = array();
        
        foreach( $fields as $field ){
            
            if ( isset($category[$field]) ){
                
                switch( $field ){
                    
                    case'category_id':
                        $role_obj = Category::firstOrNew(['category_id' => $category['category_id'] ] );
                        break;
                    
                    case'category_slug':
                        $role_obj = Category::firstOrNew(['category_slug' => $category['category_slug'] ] );
                        break;
                    
                }
            }
            
        }
        if( empty($output) || $output == 'array' ){
            
            $category_array = $role_obj->toArray();
            return $category_array;
            
        }elseif( $output =='object' ){
        
            return $category_obj;
        }
        
    }
    
    public function getCategoryTitles( $type ){
        
//      $category_object = DB::table( $this->table )
//           ->select( $this->table.'.category_title')
//           ->where('category_type','=', $type )
//           ->where('status','=', 'active' )
//           ->get();
//      return $category_object;

        $category_array = Category::select('category_title','category_slug')->
            where('category_type','=', $type )->get()->toArray();
        
        return $category_array;
    }
    
    public function getLastCategoryTitles($type){
        
        /****gets the last inserted Category***/
        
        $category_array = Category::select('category_title','category_slug')->
            where('category_type','=', $type )->take(1)->
            orderBy('category_id','desc')->get()->toArray();
        
        return $category_array;
    }
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function foods(){
        return $this->hasMany('App/Model/Food');
    }
    /***
     * 
     */
    public function user(){
        return $this->belongsTo('App/Model/User');
    }
    
}

?>