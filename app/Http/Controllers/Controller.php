<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SetupController;

//use App\Http\Controllers\Admin;
//++++++++++++++++++++++++++ Custom Pagination
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

//++++++++++++++++++++++++++ End Of Custom Pagination
//use Auth;
use App\Models\SuperClass;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Url;
use App\Models\Sidebar;
use App\Models\Notification;
use App\Models\Setting;

use App; //## for getting local language
use DB;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
//use Illuminate\Foundation\Application;
//use Illuminate\Routing\Redirector;
//use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private $_class_identifier; 
    private $_namespace_slug;
    
    public static $POST_METHOD = 'post';
    public static $GET_METHOD = 'get';
    
    protected $_permission_array ;
    protected $_injection_array=['Application','Redirector','Request'];
    protected $_app ;
    protected $_redirector ;
    protected $_request ;
   
    public function __construct( array $params=[] ){
        

        $this->pluginSetup();      
        $this->getUserSidebar()->getNotify();

        if( !empty($params['class_name'])){
            $this->setControllerAcl($params['class_name']);
        }    
        //+++++++++++++++++Set Settings++++++++++++++++    

        $setting  = new Setting();
        $setting_array = $setting->getAllSettings();
        
        $site_title = !empty($setting_array[0]['setting_site_title'])?$setting_array[0]['setting_site_title']:config('site.site_title');
        view()->share('SITE_TITLE',$site_title);


        //+++++++++++++++++++++++++++++++++   
        view()->share( '_global_lang' , App::getLocale() );
        view()->share( '_fa_lang' , 'fa' );
        view()->share( '_en_lang' , 'en' );

        view()->share( 'NORMAL_STATUS'  ,SuperClass::$NORMAL_STATUS);
        view()->share( 'DEACTIVE_STATUS',SuperClass::$DEACTIVE_STATUS);
        view()->share( 'BANNED_STATUS'  ,SuperClass::$BANNED_STATUS);
        view()->share( 'DELETED_STATUS' ,SuperClass::$DELETED_STATUS);    
        
        return $this;
      
    } /** ENDOF __constructor() */
    
    protected function getNotify(){
        
        $notify = new Notification();
        $notification_array = $notify->getAllNotifications();
        view()->share( '_global_notification_array' , $notification_array );
        return $this;
        
    }
    
    static public function getPermissionSlug($namespace=NULL,$controller,$action=NULL){
        
        $action_slug = '';
        
        if(!is_null($namespace)){
            $namespace.='_';
        }
        if(is_null($action)){
            $action = 'index';
        }

        $chunks = preg_split('/(?=[A-Z])/', $action , -1, PREG_SPLIT_NO_EMPTY);
        foreach( $chunks as $chunk ){
            $action_slug.='_'.strtolower($chunk);
        }
        
        return strtolower($namespace.$controller.$action_slug);
    }
        
    protected function getUserSidebar(){
        
        // Getting the Global Sidebars
        if(!empty( auth()->user() )){

            $role_id = auth()->user()->role_id ;
            $role_id = 1 ;
            $sidebar_obj = new Sidebar();
            $sidebar = $sidebar_obj->getSidebarBy( array('role_id'=>$role_id));
            if( !empty($sidebar) ){
                $url_array = $sidebar_obj->getSidebarUrls( $sidebar[$role_id]['sidebar_id'] );
                $sidebar[$role_id]['urls'] = $url_array;
                //dd( $sidebar );
                view()->share ( '_global_sidebar_array', $sidebar[$role_id] );
            }
            //dd($sidebar[$role_id]);
        
        }
        return $this;
        
    }
       
    protected function paginator( array $items , $per_page = NULL ){

        //Get current page form url e.g. &page=6
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        //Create a new Laravel collection from the array data
        $collection = new Collection($items);

        //Define how many items we want to be visible in each page
        if( is_null($per_page) ){
            $per_page = 1;
        }

        //Slice the collection to get the items to display in current page
        $currentPageSearchResults = $collection->slice($currentPage * $per_page, $per_page)->all();

        //Create our paginator and pass it to the view
        $paginatedSearchResults= new LengthAwarePaginator($currentPageSearchResults, count($collection), $per_page);
        
        return $paginatedSearchResults ;
        //return view('search', ['results' => $paginatedSearchResults]);    
    }
    
    protected function pluginSetup(){
        
        if( !empty($this->_permission_role_array) ){
            
            $role_object = new Role();
            
            foreach ( $this->_permission_role_array as $key => $role ){
                //dd( !empty($role['permissions']) );
                if( $role['role_slug'] == 'default' && !empty($role['permissions'])){
                    foreach( $role['permissions'] as $key => $perm  ){  
                        
                        $perm_object = new Permission();
                        if( !$perm_object->checkPermissionExists( $perm_object ) ){

                            $perm_object->permission_slug = $perm['permission_slug'] ;
                            $perm_object->permission_title = $perm['permission_title'] ;
                            $perm_object->save();
                         }
                    }
                    
                }else if( !$role_object->checkRoleExists($role['role_slug']) && !empty($role['permissions']) ){
                    
                    foreach( $role['permissions'] as $key => $perm ){
                        
                        $perm_object = new Permission();
                        $perm_object->permission_slug = $perm['permission_slug'] ;
                        
                        $role_object->role_slug   = $role['role_slug'];
                        $role_object->role_title  = $role['role_title'];
                        $role_object->role_status = $role['role_status'];
                        
                        if( $role_object->save() ){
                            
                            if( !$perm_object->checkPermissionExists( $perm_object ) ){
                                
                                $perm_object->permission_title = $perm['permission_title'] ;
                                $role_object->permissions()->save( $perm_object );
                            }
                        }
                    }

                }
                
            }
        }
        /***********************************/
        if( !empty( $this->_url_action_array ) ){
            
            $url_obj = new Url();
            $sidebar = new Sidebar();
            $sidebar = Sidebar::find(1);
            $parent_id = '';
            $order = 1 ;
            
            if( !$url_obj->checkUrlExists( $this->_controller, $this->_url_action_array['url_slug'] ) ){

                $url_obj->url_slug = $this->_url_action_array['url_slug'] ;
                $url_obj->url_title = $this->_url_action_array['url_title'] ;
                $url_obj->url_controller= $this->_controller ;
                $url_obj->url_namespace = $this->_namespace;
                $url_obj->save();
                
                $sidebar->urls()->attach( [
                    $url_obj->url_id=>[
                        'url_parent_id'   => 0, // its a Parent !
                        'url_depth_level' => 1,
                        'url_order'       => $order
                    ] 
   
                ]);
                
                $parent_id = $url_obj->url_id;
            
            }
            if( !empty( $this->_url_action_array['children'] ) ){

                foreach ( $this->_url_action_array['children'] as $index => $url ){
                    
                    $url_obj = new Url();
                    
                    if( !$url_obj->checkUrlExists( $this->_controller, $url['url_slug'] ) ){

                        $url_obj->url_slug = $url['url_slug'] ;
                        $url_obj->url_title = $url['url_title'] ;
                        $url_obj->url_controller= $this->_controller ;
                        $url_obj->url_namespace = $this->_namespace;
                        $url_obj->save();
                        
                        $sidebar->urls()->attach( [
                            $url_obj->url_id=>[
                                'url_parent_id'   => $parent_id,
                                'url_depth_level' => 2 ,
                                'url_order'       => ++$order
                            ] 
   
                        ]);

                    }
                }
            }
        }
        return $this;
        
    }/** ENDOF pluginSetup() */
    
    protected function getControllerSlug( $class_name ){
        
        $chunks = preg_split('/(?=[A-Z])/', $class_name, -1, PREG_SPLIT_NO_EMPTY);
        
    }
    
    private function setPermissionsSlug( $function_name, $options = NULL ){
                
        $chunks = preg_split('/(?=[A-Z])/', $function_name, -1, PREG_SPLIT_NO_EMPTY);

        $perm_object = new Permission();
        $perm_object->permission_slug  = $this->_namespace_slug;
        $perm_object->permission_slug .='_'. $this->_class_identifier; 
        
        foreach( $chunks as $chunk ){
            $perm_object->permission_slug.='_'.strtolower($chunk);
        }
        //dd( $perm_object->permission_slug );
        if( in_array( $perm_object->permission_slug ,config('site.exceptionPermissions'))){
            //dd('yup');
            $perm_object->permission_exception = TRUE;
        }
        //dd($perm_object->permission_slug );

        if( !$perm_object->checkPermissionExists( $perm_object->permission_slug ) ){

            $result = $perm_object->save();
            if($result){
                //TRUE
            }
        }
        //Slug already exist in database
        return TRUE;
    }
    
    public function setControllerAcl( $class_name ){
        
        $class = new \ReflectionClass($class_name);
        $methods = $class->getMethods(\ReflectionMethod::IS_PUBLIC);
        $chunks = preg_split('/(?=[A-Z])/', $class_name, -1, PREG_SPLIT_NO_EMPTY);
        $this->_class_identifier = strtolower(current(array_slice($chunks, -2 )));
        $namespace = strtolower(trim(current(array_slice($chunks, -3 )),'\\'));
        $temp_array = config('site.registeredNamespaces');
        
        //var_dump($chunks);
        //var_dump($namespace);
        
        if( in_array($namespace,$temp_array) ){
            $this->_namespace_slug = $namespace;
        }else{
            $this->_namespace_slug = NULL;
        }
        //var_dump($this->_namespace_slug);

        foreach( $methods as $method ){
            
            if ( $method->class==$class_name && $this->sliceMethodName($method->getName()) ) {
               // if()){   
                    $method_name = $this->sliceMethodName( $method->getName() );
                    $this->setPermissionsSlug($method_name);
                   
                    $slug = self::getPermissionSlug($this->_namespace_slug,$this->_class_identifier,$method_name);
                    //dd($slug);
                    //var_dump($slug);
                    //var_dump($method->getName().':::'.$slug.'::get'.$method_name.'::post'.$method_name);
                    $this->middleware('acl:'.$slug,['only'=>[self::$POST_METHOD.ucfirst($method_name),self::$GET_METHOD.ucfirst($method_name)] ]);
                //}
                
            }
           
        }
        //dd();
        return TRUE;
                
    }/** ENDOF setPermissions */
    
    private function sliceMethodName( $function_name ){

        if( substr($function_name, 0,strlen(self::$POST_METHOD))==self::$POST_METHOD ){
  
            $temp_name = substr($function_name, strlen(self::$POST_METHOD));
            return $temp_name ;
            
        }else if( substr($function_name, 0,strlen(self::$GET_METHOD))==self::$GET_METHOD ){
            
            $temp_name = substr($function_name, strlen(self::$GET_METHOD));
            return $temp_name ;
            
        }
        
        return FALSE;

    }
}
