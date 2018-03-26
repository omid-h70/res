<?php

namespace App\Models;

use DB;

class Sidebar extends SuperClass
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sidebars';
    protected $primaryKey = 'sidebar_id';
    /*
    |--------------------------------------------------------------------------
    | Relationship Methods
    |--------------------------------------------------------------------------
    */


    public function getAllSidebars( $status = NULL ){
	
    	$sidebar_array = Sidebar::select("sidebars.*")
            ->where('sidebar_slug','!=','root')->get()->toArray();
    	return $sidebar_array;
    }
    
    public function getSidebarBy( array $input_array , $output = NULL ){
	
    	$fields = array ('sidebar_id','sidebar_slug','role_id');
        $sidebar_array = $url_array = array();
        
        foreach( $fields as $field ){
            
            if ( isset($input_array[$field]) ){
                
                switch( $field ){                    
                    case'sidebar_id':
                        $sidebar_obj = Sidebar::firstOrNew(['sidebar_id' => $input_array['sidebar_id'] ] );
                        break;
                    
                    case'sidebar_slug':
                        $sidebar_obj = Sidebar::firstOrNew(['sidebar_slug' => $input_array['sidebar_slug'] ] );
                        break;
                    
                    case 'role_id':
                        $role = Role::find($input_array['role_id']);
                        
                        foreach( $role->sidebars as $sidebar ){
                            $sidebar_array[$role->role_id] = $sidebar->toArray() ; 
                        }

                        return $sidebar_array;
                        
                    break;
                        
                                          
               }
            }
            
        }
        
        if( empty($output) || $output == 'array' ){
            
            $sidebar_array = $sidebar_obj->toArray();
            return $sidebar_array;
            
        }elseif( $output =='object' ){
            
            return $sidebar_obj;
        }
        
    }
   
    public function getSidebarUrls( $sidebar_id ,$depth_level = NULL ){

        $depth_level = !empty( $depth_level )?$depth_level:1; 
        $url_array = array();
        
	$sidebar_mixed_array = DB::table('sidebar_url')
            ->where('sidebar_id','=',$sidebar_id) 
            ->where('url_depth_level','=',$depth_level)  
            ->get();  
        //var_dump( $sidebar_mixed_array );
        
        foreach( $sidebar_mixed_array as $key => $parent_url ){
            
            $child_url_array = array();

            $url_array[$key] = Url::find( $parent_url->url_id )->toArray();
            $object_array = DB::table('sidebar_url')
                ->select('url_id')
                ->where('url_parent_id','=',$parent_url->url_id )
                ->where('sidebar_id','=',$sidebar_id)  
                ->get();    
                 
            //dd( $object_array );
            foreach( $object_array as $child_key => $child_url){
                
                $child_url_array[] = Url::find( $child_url->url_id )->toArray();
                //$child_url_array[$child_key] =  (array) $child_url;
            }
            $url_array[$key]['children'] = $child_url_array;
            
        }       

        return $url_array;

    }

    public function getSidebarRoles( $sidebar_id ){
	
    	$role_array = array();
    	$sidebar = Sidebar::find($sidebar_id); 
    	foreach( $sidebar->roles as $role ){
    	   $role_array[$sidebar_id][] = $role->toArray() ;	
    	}
        
        return $role_array;

    }

    /**
     * many-to-many relationship method
     *
     * @return QueryBuilder
     */
    public function roles(){
        return $this->belongsToMany('App\Models\Role');
    }
    /**
     * many-to-many relationship method
     *
     * @return QueryBuilder
     */
    public function urls(){
    
        return $this->belongsToMany('App\Models\Url')
            ->withPivot('url_parent_id','url_depth_level','url_order');
    }

}
