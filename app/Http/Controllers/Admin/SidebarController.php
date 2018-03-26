<?php
namespace App\Http\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Redirector;
use App\Models\Url;
use App\Models\Sidebar;
use App\Models\Role;


/**
 *
 * @author Omid
 *        
 */


class SidebarController extends  Controller{ 

    protected $_request;
    // TODO - Insert your code here
    //protected $_permission_array = ['default'=> ['add_sidebar','edit_sidebar'] ];
    protected $_controller  = 'sidebar';
    protected $_namespace   = 'admin';

    protected $_url_action_array =[
        
        'url_title'=>'Sidebar',
        'url_slug' =>'sidebar',
        'children'=>[
            0 =>[
                'url_title'=>'Add Sidebar',
                'url_slug' =>'add-new'
            ],
            1 =>[
                'url_title'=>'See All',
                'url_slug' =>'all'
            ]
        ]    
        
    ];
     
    
    /**
     */
    public function __construct(Application $app, Request $request){
        
        $this->_request = $request;
        $this->_app = $app;
        parent::__construct();
    }
    
    public function getIndex(){

        return $this->getAll();
        // TODO - Insert your code here
    }
    
    public function getAddNew(){
        
        $sidebar_id = 1 ;

        if( !empty($sidebar_id) ){

            $sidebar = new SideBar();
            $default_sidebar_id = 1 ;
            $default_sidebar_url_array = $sidebar->getSidebarUrls( $default_sidebar_id );

            $sidebar_array = $sidebar->getSidebarBy( array('sidebar_id'=>$sidebar_id) );
            $sidebar_url_array = $sidebar->getSidebarUrls($sidebar_array['sidebar_id']);

            //dd($default_sidebar_url_array);
            //dd( $sidebar_url_array );
            $this->_request->flash();

            return view('admin.sidebar.add-new')->with([
                    'sidebar_array'     => $sidebar_array,/**** Sidebar Details *****/
                    //'sidebar_url_array' => $sidebar_url_array,/**** Urls of the Sidebar *****/
                    'default_sidebar_url_array' => $default_sidebar_url_array/**** Other Urls  *****/
                ]);
        }
    }
      
    public function postAddNew(){
    
        
        if( $this->_request->ajax() ) {

           $input_params = $this->_request->all();
           //dd( $input_params );
           $data = array('sidebar_title' => $input_params['sidebar_title'] );
           $url_array =  !empty($input_params['url_array'])?$input_params['url_array']:'';
           $url_obj = new Url();
          
           
           if( $this->validator( $data )->passes() ){
              
                $sidebar = new Sidebar();
                $sidebar->user_id = auth()->user()->getAuthIdentifier() ;
                $sidebar->sidebar_title = $input_params['sidebar_title'];
                $sidebar->sidebar_slug = strtolower( str_replace(' ', '_', $input_params['sidebar_title']) );
                $sidebar->sidebar_type ='sidebar';
                $sidebar->sidebar_status = Sidebar::$NORMAL_STATUS; 
                
                $result = $sidebar->save();

                if( $result ){
                    
                    if( !empty ( $url_array )){
                        foreach ( $url_array as $url ){

                            $order = 1;// 1 for Parents

                            if( !empty($url) ){

                                $new_parent_url = Url::firstOrNew( array(
                                    'url_id'   => $url['url_id'],
                                    //'url_slug'         => $url['url_slug'],
                                    //'url_title'        => $url['url_title'],
                                    //'url_controller'   => $url['url_controller'],
                                    //'url_namespace'    => $url['url_namespace'],                                
                                ) );
                                $sync_array[ $new_parent_url->url_id ] = [
                                    'url_parent_id'   => 0 ,// 0 for Parents
                                    'url_depth_level' => 1 ,
                                    'url_order'       => $order  ,
                                ] ;
                            }
                            if( !empty( $url['url_children'] )){

                                foreach( $url['url_children'] as $child_key => $child_url){

                                    $new_child_url = Url::firstOrNew( array(
                                        'url_id'   => $child_url['url_id'],
                                        //'url_slug'         => $url['url_slug'],
                                        //'url_title'        => $url['url_title'],
                                        //'url_controller'   => $url['url_controller'],
                                        //'url_namespace'    => $url['url_namespace'],                                
                                    ) );

                                    $sync_array[ $new_child_url->url_id ] = [    
                                        'url_parent_id'   => $url['url_id'],
                                        'url_order'       => ++$order  ,
                                        'url_depth_level' => 2
                                    ];

                                }

                            }

                        }

                        $result =  $sidebar->urls()->sync( $sync_array );
                    
                    }
                    if( !$result ){
                        $response = ['error'=>trans('admin.database_error')];
                        return response()->json( $response );
                    }
                    $response = ['no-error'=>trans('admin.done')];
                    return response()->json( $response );
                    
                }
              
            }else{  
                $response = $this->validator($data )
                      ->getMessageBag()->toArray();
                return response()->json( $response );
               
            }
        
        
        }
    }
    
    public function getAll(){

        /********************
        * Warning ::
        * Offset Error may cause by a deleted handle between tables 
        *
        ************************/

    	$sidebar_object = new SideBar();
    	$sidebar_array = $sidebar_object->getAllSidebars();
    	$role_array = $url_array = $sidebar_parent_url_array = array(); 
        
        $role_object = new Role();
        $role_array = $role_object->getAllRoles();


    	foreach( $sidebar_array as $key => $sidebar){
            
            $temp = $role_array_remp =  array();
            $role_array_temp = $role_array ;
            $temp = $sidebar_object->getSidebarRoles($sidebar['sidebar_id']);
            
            if( !empty($temp) ){
                
                $sidebar_roles = array();
                $sidebar_roles = $temp[$sidebar['sidebar_id']];
               
                foreach( $sidebar_roles as $key2 => $role  ){
                    
                    foreach( $role_array as $key3 => $role_temp ){
                        

                            if( $role_temp['role_id'] == $role['role_id']){
                                $role_array_temp[$key3]['selected'] = 'selected';
                            } 
                        
                    }
                    
                    
                }
                
                $sidebar['role_array'] = $role_array_temp;/** when search has finished***/
                $sidebar_array[$key] = $sidebar ;/** update the values ***/
                
            }
            
    	}
        
        //dd( $sidebar_array ); 
        //dd( $role_array );
            
        return view('admin.sidebar.all')
            ->with([
                'sidebar_array' => $sidebar_array,
                'role_array'    => $role_array 
            ]);
    	

    }   
  
    public function postAll(){


    }    

    public function getEdit(){
        
        $sidebar_id = $this->_request->get('id') ;

        if( !empty($sidebar_id) ){

            $sidebar = new Sidebar();
            
            $sidebar = new SideBar();
            $default_sidebar_id = 1 ;
            $default_sidebar_url_array = $sidebar->getSidebarUrls( $default_sidebar_id );

            $sidebar_array = $sidebar->getSidebarBy( array('sidebar_id'=>$sidebar_id) );
            $sidebar_url_array = $sidebar->getSidebarUrls($sidebar_array['sidebar_id']);
            
            
            foreach( $default_sidebar_url_array as $key1 => $url1){
                
                foreach( $sidebar_url_array as $key2 => $url2 ){
                    
                    if( $url1['url_id'] == $url2['url_id'] ){
                        $url1['selected'] = TRUE;
                        $default_sidebar_url_array[$key1] = $url1;
                    }
                    
                    
                }

            }
            
            //dd($default_sidebar_url_array);
            //dd( $sidebar_url_array );
            $this->_request->flash();

            return view('admin.sidebar.edit')->with([
                    'sidebar_array'     => $sidebar_array,/**** Sidebar Details *****/
                    'sidebar_url_array' => $sidebar_url_array,/**** Urls of the Sidebar *****/
                    'default_sidebar_url_array' => $default_sidebar_url_array/**** Other Urls  *****/
                ]);
        }

    }

    public function postEdit(){
        
        if( $this->_request->ajax() ) {

            $input_params = $this->_request->all();
            //dd( $input_params );
            
            switch( $input_params['action']){
                
                case 'update_sidebar':
                    
                    //dd( $input_params );
                    $sidebar = new SideBar();
                    
                    $sidebar_array = array(
                        'sidebar_id' => $input_params['sidebar_id'] ,
                        'sidebar_status' => $input_params['sidebar_status'] ,
                    );
                    $sidebar_id = $input_params['sidebar_id'] ;
                    if( !empty($input_params['sidebar_role'])  ){
                        
                        $role = $input_params['sidebar_role'] ;
                        $role_object = new Role();
                        $old_role = $role_object->checkRoleHasSidebar( $role );
                        $role_array = $sidebar->getSidebarRoles($sidebar_id  );
                        
                        $check_flag = FALSE;
                        if( !empty($role_array) ){
                            foreach( $role_array[$sidebar_id] as $temp_role ){
                                if ( $temp_role['role_slug'] == $input_params['sidebar_role'] ){
                                    $check_flag = TRUE;
                                    /***** Checks if the Role Already attached or not***/
                                }    
                            };
                        }
                        //dd( $check_flag  );
                        
                        if( !$old_role ){
                            
                            $result = $this->updateSidebar( $sidebar_array , $role );
                            if( $result ){
                                $response = ['no-error'=>trans('admin.done')];
                                return response()->json( $response ); 
                            }else{
                                $response = ['error'=>trans('admin.database_error')];
                                return response()->json( $response );
                            }
                            
                        }elseif( $old_role && $check_flag ){
                            
                            $result = $this->updateSidebar( $sidebar_array , $role );
                            if( $result ){
                                $response = ['no-error'=>trans('admin.done')];
                                return response()->json( $response ); 
                            }else{
                                $response = ['error'=>trans('admin.database_error')];
                                return response()->json( $response );
                            }
                        }else{
                            $response = ['sidebar_role'=>'a Role Cannt have More than One Sidebar'];
                            return response()->json( $response );
                        }
                        
                    }else{
                        $result = $this->updateSidebar( $sidebar_array );
                        if( $result ){
                            $response = ['no-error'=>trans('admin.done')];
                            return response()->json( $response ); 
                        }
                    }

                    if( !$result ){
                        $response = ['error'=>trans('admin.database_error')];
                        return response()->json( $response );
                    }

                break; 
                
                case'edit_sidebar':
                    
                    $data = array('sidebar_title' => $input_params['sidebar_title'] );
                    $url_array =  !empty($input_params['url_array'])?$input_params['url_array']:array();
                    
                    if( empty($url_array) ){
                        $response = ['no-error'=>trans('admin.done')];
                        return response()->json( $response ); 
                        
                    }

                    $url_obj = new Url();
                    
                    $sidebar_array = array(
                        'sidebar_id'    => $input_params['sidebar_id'] ,
                        'sidebar_title' => $input_params['sidebar_title'] 
                    );

                    if( $this->validator( $data ,'edit_sidebar' )->passes() ){

                        $result = $this->saveSidebar( $url_array , $sidebar_array );

                        if( $result ){
                            $response = ['no-error'=>trans('admin.done')];
                            return response()->json( $response ); 
                        }else{
                            $response = ['error'=>trans('admin.database_error')];
                            return response()->json( $response );
                        }

                    }else{  
                        $response = $this->validator($data )
                              ->getMessageBag()->toArray();
                        return response()->json( $response );
                    } 
                break;
            }
        }/***********ENDOF AJAX Request****************/
        
    }
    
    protected function saveSidebar( array $url_array ,array $sidebar_array = null ){
        
        if( !empty($sidebar_array['sidebar_id']) ){
            
            $sidebar = Sidebar::find( $sidebar_array['sidebar_id'] );
            $sidebar->sidebar_id = $sidebar_array['sidebar_id'];

        }else{
            $sidebar = new Sidebar();
        }  
              
        
        $sidebar->user_id = auth()->user()->getAuthIdentifier() ;
        
        if( !empty($sidebar_array['sidebar_title']) ){
            $sidebar->sidebar_title = $sidebar_array['sidebar_title'];
            $sidebar->sidebar_slug =  mb_strtolower( str_replace(' ', '_', trim($sidebar_array['sidebar_title']) ) ) ;
        }
        
        if( !empty($sidebar_array['sidebar_status'])){
            $sidebar->sidebar_status = $sidebar_array['sidebar_status']; 
        }else
            $sidebar->sidebar_status = ucfirst(Sidebar::$NORMAL_STATUS); 

        //dd( $sidebar );
        
        $result = $sidebar->save();

        if( $result ){

            foreach ( $url_array as $url ){

                $order = 1;// 1 for Parents

                if( !empty($url) ){

                    $new_parent_url = Url::firstOrNew( array(
                        'url_id'   => $url['url_id'],                             
                    ) );
                    $sync_array[ $new_parent_url->url_id ] = [
                        'url_parent_id'   => 0 ,// 0 for Parents
                        'url_depth_level' => 1 ,
                        'url_order'       => $order  ,
                    ] ;
                }
                if( !empty( $url['url_children'] )){

                    foreach( $url['url_children'] as $child_key => $child_url){

                        $new_child_url = Url::firstOrNew( array(
                            'url_id'   => $child_url['url_id'],                           
                        ) );

                        $sync_array[ $new_child_url->url_id ] = [    
                            'url_parent_id'   => $url['url_id'],
                            'url_order'       => ++$order  ,
                            'url_depth_level' => 2
                        ];

                    }

                }

            }

            $result =  $sidebar->urls()->sync( $sync_array );
            //dd( $result );
            
            if( $result )
                return $result;
            else
                return FALSE;
        }
        
    }
    
    protected function updateSidebar( array $sidebar_array , $role = NULL ){
        
        $sidebar = Sidebar::find( $sidebar_array['sidebar_id'] );
        $sidebar->sidebar_id = $sidebar_array['sidebar_id']; 
        $result1 = $result2 = '';
        
        if( $sidebar->sidebar_status != $sidebar_array['sidebar_status'] ){
            
            $sidebar->sidebar_status = $sidebar_array['sidebar_status'];
            $result1 = $sidebar->save();

        }

        if( !empty( $role ) && $role!='--none--'){
       
            $role_slug = $role ;
            $role = new Role();
            $role_array = $role->getRoleBy( array('role_slug' => $role_slug ));
            //dd( $role_array );
            $result2 = $sidebar->roles()->sync( [ $role_array['role_id'] ]);
       
        }

        if( empty($result1) && empty($result2) )
            return TRUE;
        
        if( $result1 || $result2) 
            return TRUE;

        
    }
    
    protected function validator( array $data ,$mode = NULL ){
        
        switch( $mode ){
            case 'edit_sidebar':
                return Validator::make($data, [
                    'sidebar_title'          => 'required|min:3|max:200',
                ]);
                break;
                
            default :
                return Validator::make($data, [
                    'sidebar_title'          => 'unique:sidebars|required|min:3|max:200',

                ]);
                break;
        }
        

    
    }
}

?>
