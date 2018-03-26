<?php

namespace App\Http\Controllers\Admin;


use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Redirector;
use App\Models\Permission;
use App\Models\Role;

/*
|--------------------------------------------------------------------------
| Access Control Layer (Acl) Controller
|--------------------------------------------------------------------------
|
*/  


class AclController extends Controller {
    
    protected $_request;
    protected $_role_object ;
    
    protected $_controller  = 'acl';
    protected $_namespace   = 'admin';
    
    
    protected $_url_action_array =[
        'url_title'=>'Acl',
        'url_slug' =>'acl',
        'children'=>[
            0 =>[
                'url_title'=>'Add New',
                'url_slug' =>'add-new'
            ],
            1 =>[
                'url_title'=>'See All',
                'url_slug' =>'all'
            ]
        ]    
    ];
     

    public function __construct( Request $request ){
        
        $this->_request = $request ;
        parent::__construct(['class_name'=>self::class]);

    }

    /*
     *
     */

         /**
     * 
     * @return 
     */
    public function getIndex(){
        
        return $this->getAll(); 

    }


    public function getAll(){
        
        $perm = new Permission();
        $perm_array = $perm->getAllPermissions();
        $view_params['perm_array'] = $perm_array;


        $role = new Role();
        $role_perm_array =  $role->getAllRolesAndPerms();
        $view_params['role_perm_array'] = $role_perm_array;

        $role_array = $role->getAllRoles();
        $view_params['role_array'] = $role_array;
        
        return view('admin.acl.index')
           ->with('ViewParams', $view_params);


    }
    
    public function postAddNewRole(){
        
        if( $this->_request->ajax() ) {

           $input_params = $this->_request->all();

           $data = array('role_title' => $input_params['role_title'] );

           if( $this->validator( $data , 'role_title' )->passes() ){

                $role = new Role();
                if( isset($input_params['role_id'])  ){
                    $role->role_id = $input_params['role_id'];
                }
                $role->role_title =  $input_params['role_title'];
                $role->role_slug  =  strtolower($input_params['role_title']);
                $result = $role->save() ;
                
                if( $result ){ 
                    
                    if( !empty($input_params['permission_array']) ){ 
                        
                        $perm_array = $input_params['permission_array'];
                        
                        foreach ( $perm_array as $perm ){
                            if( isset($perm) && $perm!=null){ 
                                $permission = Permission::firstOrNew( array(
                                    'permission_slug' => $perm 
                                ) );
                                $sync_array[] = $permission->permission_id;
                            }
                        }
                        $result =  $role->permissions()->sync( $sync_array );
                        
                    }                                            
                }

                if( !$result ){
                    $response = ['error'=>trans('admin.database_error')];
                    return response()->json( $response );
                }
                $response = ['no-error'=>trans('admin.done')];
                return response()->json( $response );
                

           }else{    
                 $response = $this->validator( $data ,'role_title' )
                     ->getMessageBag()->toArray();
                 return response()->json( $response );
           }

       }

    }/* ENDOF postAddNew() */

    /*********/
    
    public function postEditRole(){
        
        $response = array();
        if( $this->_request->ajax() ) {
            
            $role_id = $this->_request->input('role_id') ;
            $action  = $this->_request->input('action') ;
            
            
            if( !empty($role_id) ){
                
                switch( $action ){

                    case'edit':
                        $perm_array = $this->_request->input('permission_array');
                        $role_title = $this->_request->input('role_title') ;
                        
                        $role = new Role();
                        $role_array = $role->getRoleBy( array('role_id'=> $role_id) );
                        $perm_array = $role->getRolePermissions($role_id);

                        $response = [
                            'no-error'   => trans('admin.done'),
                            'perm_array' => empty($perm_array)?'':$perm_array[$role_id],
                            'role_array' => $role_array
                        ];

                        return response()->json( $response );
                        break;
                    
                    case'save':
                        
                        $perm_array = $this->_request->input('permission_array');
                        $role_title = $this->_request->input('role_title') ;

                        $data = array('role_title'=>$role_title);

                        if( $this->validator( $data ,'edit' )->passes() ){

                            $role = Role::find($role_id);

                            $role->role_title =  $role_title;
                            $role->role_slug  =  mb_strtolower( str_replace(' ', '_', trim($role_title) ) ) ;

                            $attributes = array( 'role_id' => $role_id );
                            $values = array( 'role_title'=>$role['role_title'],'role_slug'=>$role['role_slug']);
                            $result = $role->save();
                            
                            if( $result ){
                                
                                if( !empty( $perm_array )){
                                    foreach ( $perm_array as $perm ){

                                        if( isset($perm) && $perm!=null){ 
                                            $permission = Permission::firstOrNew( array(
                                                'permission_slug' => $perm 
                                            ) );
                                            $sync_array[] = $permission->permission_id;
                                        }
                                    }
                                    $result =  $role->permissions()->sync( $sync_array );
                                }
                                
                                if( $result ){

                                    $response = [
                                       'no-error' => trans('admin.done'),
                                    ];
                                }

                            }else{

                                $response = [
                                    'error' => trans('admin.database_error'),
                                ];
                            }

                            return response()->json( $response );

                        }else{
                            $response = $this->validator( $data ,'edit' )
                                ->getMessageBag()->toArray();
                            return response()->json( $response );
                        }
                        
                        break;
                    
                    case'edit-status':
                        
                        $role_status = $this->_request->input('role_status');
                        
                        $role = new Role();
                        $result = $role->updateRole(array(
                            'role_id'   => $role_id,
                            'role_status'=>$role_status
                        ));
                        
                        if( $result ){
                            $response = [
                               'no-error'   => trans('admin.done'),
                            ];
                        }else{
                            $response = [
                               'error'   => trans('admin.database_error'),
                            ];
                            
                        }
                        return response()->json( $response );
                        
                        break;
                    
                    case'delete-role' :
                        $role = new Role();
                        $result = $role->updateRole(array(
                            'role_id'    => $role_id,
                            'role_status'=> Role::$DELETED_STATUS
                        ));
                        
                        if( $result ){
                            $response = [
                               'no-error'   =>trans('admin.done'),
                            ];
                        }else{
                            $response = [
                               'error'   =>trans('admin.database_error'),
                            ];
                            
                        }
                        return response()->json( $response );
                        
                        break;
                }
            
            }/****** if( $action =='edit' && !empty($role_id)***********/

            //return view('admin.acl.edit');
        } // if ajax request
    }

    public function getEdit(){
        
    }

    /*********/
    protected function validator( array $data,  $type = null )
    {  

        switch ( $type ){
            case'edit':

                return Validator::make($data, [
                    'role_title'      => 'required|alpha|max:50',
                ]);
                break;
            
            case'role_title':

                return Validator::make($data, [
                    'role_title'      => 'required|alpha|max:50|unique:roles',
                ]);
                break;
            /*************preg_match('/^[a-zA-Z0-9 .\-]+$/i',$sth)*****************/
            
            default:
                return Validator::make($data, [
                    'name'          => 'required|max:255|unique:foods',
                    'category'      => 'required|max:255',
                    'image'         => 'image|max:10000',
                    'tags'          => 'max:255',
                ]);
                break;

        }
    }
}
?>
