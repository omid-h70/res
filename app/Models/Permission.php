<?php

namespace App\Models;

use DB;

class Permission extends SuperClass
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permissions';
    protected $primaryKey = 'permission_id';
    protected static $exceptionList ;
    protected $fillable = [
        'permission_slug',
        'permission_title',
        'permission_exception', 
        'permission_disc',
    ];

    public function getAllPermissions()
    {
        $perm_array = Permission::where('permission_slug','!=','root')
            ->get()->toArray();
    
        return $perm_array;
    }
    
    public static function getExceptionList(){
        return self::$exceptionList;
    }
    
    public function getPermissionBy(array $permission, $output = NULL ){

        $fields = array ('permission_id','permission_slug');
        $permission_array = array();
        
        foreach( $fields as $field ){
            
            if ( isset($permission[$field]) ){
                
                switch( $field ){
                    
                    case'permission_id':
                        $permission_obj = self::firstOrNew(['permission_id' => $permission['permission_id'] ] );
                    break;
                    
                    case'permission_slug':
                        $permission_obj = self::firstOrNew(['permission_slug' => $permission['permission_slug'] ] );
                    break;
                    
                }
            }
            
        }
        if( empty($output) || $output == 'array' ){
            
            $permission_array = $permission_obj->toArray();
            return $permission_array;
            
        }elseif( $output =='object' ){
            return $permission_obj;
        }
        
    }
    
    public function checkPermissionExists( $permission_slug )
    {
        $result =  Permission::select('permission_slug')
            ->where('permission_slug',$permission_slug)
            ->get()->take(1);

        if( count($result)>0 ){
            $perm_array = $result->toArray();
            return $perm_array;
        }    
        else
            return FALSE;
    }
    
    /*
    |--------------------------------------------------------------------------
    | Relationship Methods
    |--------------------------------------------------------------------------
    */

    /**
     * many-to-many relationship method
     *
     * @return QueryBuilder
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

}

?>