<?php

namespace App\Models;

use DB;

class Role extends SuperClass
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';
    protected $primaryKey ='role_id';


    protected $guarded = ['role_title','role_slug'];
    //protected $fillable =[]  ;
    
    /*
    |--------------------------------------------------------------------------
    | Relationship Methods
    |--------------------------------------------------------------------------
    */

    public function __construct(){
        parent::__construct();
        return $this;
    }
    
    public function getAllRoles(){
        $role_array = Role::where('role_slug','!=','super_user')
            ->get()->toArray();
        return $role_array;
    }

    public function getAllRolesAndPerms(){

        $role_permission_array = Role::select('roles.*','permissions.*')
            ->leftjoin('permission_role','roles.role_id','=','permission_role.role_id')
            ->leftjoin('permissions','permission_role.permission_id','=','permissions.permission_id') 
            ->where('permissions.permission_slug','!=','root')
            ->get()->toArray();
        
        return $role_permission_array;
    }
    
    public function checkRoleExists( $role ){
        $role_object = DB::table( $this->table )
            ->select('roles.role_slug')
            ->where('role_slug','=',$role)
            ->first();

        return $role_object ;
    }
    
    public function checkRoleHasPermission( $role ){
        
        //++Already Exists in User Model
        
        
        
    }
    
    public function checkRoleHasSidebar( $role_slug ){
        
        $result = Role::where('role_slug','=',$role_slug)
            ->get()->toArray();
        $role_array = $result[0];
        
        $result = DB::table('role_sidebar')
            ->where('role_id','=',$role_array['role_id'])->get();
        
        foreach ( $result as $key => $value ){
            $temp_array[] = (array) $value;
        }
        if( !empty($temp_array) ){
            return $temp_array;
        }else{
            return FALSE;
        }
        
    }  
    
    public function getRoleBy( array $role, $output = NULL ){

        $fields = array ('role_id','role_slug');
        $role_array = array();
        
        foreach( $fields as $field ){
            
            if ( isset($role[$field]) ){
                
                switch( $field ){
                    
                    case'role_id':
                        $role_obj = Role::firstOrNew(['role_id' => $role['role_id'] ] );
                        break;
                    
                    case'role_slug':
                        $role_obj = Role::firstOrNew(['role_slug' => $role['role_slug'] ] );
                        break;
                    
                }
            }
            
        }
        if( empty($output) || $output == 'array' ){
            
            $role_array = $role_obj->toArray();
            return $role_array;
            
        }elseif( $output =='object' ){
        
            return $role_obj;
        }
        
    }
    
    public function getRolePermissions( $role_id ){
    
        $permission_array = array();
        $role = Role::find($role_id);
        $permission_array[$role_id]='';   
        foreach( $role->permissions as $permission ){
           $permission_array[$role_id][] = $permission->toArray() ; 
        }
        //dd($permission_array);
        return $permission_array;

    }
    
    public function updateRole( array $role_array, array $perm_array = Null ){
        
        $role = Role::find($role_array['role_id']);
        $role->role_status = $role_array['role_status'];

        return $role->save();

    }

    /**
     * one-to-many relationship method.
     *
     * @return 
     */
    public function users(){
        return $this->hasMany('App\Models\User');
    }
    /**
     * many-to-many relationship method.
     *
     * @return QueryBuilder
     */
    public function sidebars(){
        return $this->belongsToMany('App\Models\Sidebar');
    }

    /**
     * many-to-many relationship method.
     *
     * @return QueryBuilder
     */
    public function permissions(){
        return $this->belongsToMany('App\Models\Permission');
    }

}

?>
