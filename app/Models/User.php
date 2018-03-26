<?php

namespace App\Models;

use App\Models\Role;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends SuperClass implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable,  CanResetPassword;

    
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_first_name',
        'user_last_name',
        'user_status', 
        'user_email',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $_master_role = 'super_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['user_password_confirmation', 'user_password','remember_token'];
    /*
     * One to Many RelationShip
     * with Article Model
     * 
     */
    public function registerUser( array $user, array $role = NULL){

    	$user_object = !empty($user['user_id'])?User::Find($user['user_id']):new User();
        
        //dd( $user_object->user_id );
        if (!empty($user['user_first_name']) ){
            $user_object->user_first_name = $user['user_first_name'];
        }
    	
        if(!empty($user['user_password'])){
            $user_object->user_password   = bcrypt( $user['user_password'] );
        }
    	
    	$user_object->user_email      = $user['user_email'];
    	$user_object->user_status     = User::$NORMAL_STATUS;
    	
        $role_object = new Role();
        
    	if( !empty($role) ){
            //$role_object->role_slug = $role['role_slug'];
            $role_slug = $role['role_slug'];
            
        }else{    
            //$role_object->role_slug = 'guest';
            $role_slug = 'guest';
        }
        
        $selected_role = $role_object->getRoleBy( array('role_slug' => $role_slug),'object' );
        //dd( $selected_role );
        $user_object->role()->associate( $selected_role );

        if( $user_object->save() ) {
            return TRUE;
        }
        
        return FALSE;
        
    }
    
    public function updateUser( array $input_user){
        
        $user = new User();
        $role = new Role();
        
        $user = User::find($input_user['user_id']);
        
        if( !empty($input_user['user_role'])){
            $selected_role = $role->getRoleBy( array('role_slug'=>$input_user['user_role']) );
            $user->role_id = $selected_role['role_id'];
        }
        
        if( !empty($input_user['user_status']) ){
            $user->user_status = $input_user['user_status'];
        }
        
        $result = $user->save();
        
        return $result;
        
    }
    
    public  function getAllUsers( array $params = NULL ){
        
        if( isset($params['status']) && $params['status']!= NULL ){
            
            switch ($params['status']){
                case self::$NORMAL_STATUS:
                    
                break;
                case self::$BANNED_STATUS:
                    
                break;
                    
                //case $this->_waiting_status:
                //break;
                    
            }
            
            
        }
        $user_array = User::where('role_id','!=',1)
                ->get()->toArray();

        foreach( $user_array as $key => $user ){
            
            $role_array = Role::find($user['role_id'])->toArray();
            $user['user_role'] = $role_array;
            $user_array[ $key ] = $user;
        }
        return $user_array;
        
    }
    /**
     * 
     * 
     *
     */
    public function checkUserRole( $user_id ){
        
        $user = User::findOrNew($user_id);
        
        if( $user->role->role_slug == $this->_master_role ){
            return TRUE;
        }
        
        return FALSE;
    }
    /**
     * One to Many RelationShip
     * with Article Model
     *
     */
    public function can( $permission = NULL )
    {   
        if( !is_null($permission)  ){
            $user_id = auth()->user()->getAuthIdentifier() ;
            $perm = new Permission();
            $temp = $perm->getPermissionBy(['permission_slug'=>$permission]);
            if( $this->checkUserRole($user_id) || $temp['permission_exception']){
                return TRUE;
            }
        }
        return !is_null($permission) && $this->checkPermission($user_id,$permission);
    }
    /**
     * Check if the permission matches with any permission user has
     *
     * @param  String permission slug of a permission
     * @return Boolean true if permission exists, otherwise false
     */
    protected function checkPermission($user_id,$permission)
    {   
        //$permissions = $this->getAllPermissionsFormAllRoles();
        $user = User::findOrNew($user_id);
        $role = new Role();
        $slugs = array();
        
        $permissions = $role->getRolePermissions( $user->role->role_id );
        //dd( $permissions );
        if(!empty($permissions) && is_array($permissions[$user->role->role_id])){
            foreach( $permissions[$user->role->role_id] as $perm ){
                //dd($perm);
                $slugs[] = isset($perm['permission_slug'])?$perm['permission_slug']:'';
            }
        }
        $permissionArray = is_array($permission) ? $permission : [$permission];

        //dd(array_intersect($slugs, $permissionArray));
        return count(array_intersect($slugs, $permissionArray));
    }
    /**
     * Get all permission slugs from all permissions of all roles
     *
     * @return Array of permission slugs
     */
    protected function getAllPermissionsFormAllRoles()
    {
        //$permissions = $this->roles->load('permissions')->fetch('permissions')->toArray();
        $perm = new Permission(); 
        $perm_array = $perm ->getAllPermissions();
        //dd( $perm_array );

        return array_map('strtolower', array_unique( array_flatten( 
            array_map( function ($permission) {
            return array_fetch($permission, 'permission_slug');

        }, $perm_array))));
    }
    
    /**
     * Change the default 'password' field name to 'user_password'
     * 
     *
     * @return 
     */
    
    public function getAuthPassword() {
        return $this->user_password;
    }

    /*
    |--------------------------------------------------------------------------
    | Relationship Methods
    |--------------------------------------------------------------------------
    */


    /**
     * One-To-Many Relationship Method for accessing the User->roles
     *
     * @return QueryBuilder Object
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }
    /**
     * a Single User Can add Multiple Categories
     * 
     */
    public function categories()
    {
        /** user_id is foreign key*/
        return $this->hasMany('App\Models\Category','user_id');
    }
    /**
     * a Single User Can add Multiple Foods
     *
     */
    public function foods()
    {
        return $this->hasMany('App\Models\Food');
    }
    

}
