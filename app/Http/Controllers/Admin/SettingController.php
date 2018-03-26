<?php

namespace App\Http\Controllers\Admin;


use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Redirector;
use App\Models\Setting;
use App\Models\Role;

/*
|--------------------------------------------------------------------------
| Access Control Layer (Acl) Controller
|--------------------------------------------------------------------------
|
*/  


class SettingController extends Controller {
    
    protected $_request;
    protected $_role_object ;
    protected $_controller  = 'setting';
    protected $_namespace   = 'admin';
    
//    protected $_url_action_array =[
//      ... 
//    ];
     

    public function __construct( Request $request ){
        $this->_request = $request ;
        parent::__construct(['class_name'=>self::class]);
    }

    public function getIndex($view='admin.setting.index'){
        
        $setting = new Setting();
        $setting_array = $setting->getAllSettings();
        //dd( $setting_array );

        return view($view)
            ->with([
               'site_title' =>!empty($setting_array[0]['setting_site_title'])?$setting_array[0]['setting_site_title']:config('site.site_title'),
               'multi_lang' =>!empty($setting_array[0]['setting_multi_lang'])?$setting_array[0]['setting_multi_lang']:'',
               'timeformat' =>!empty($setting_array[0]['setting_timeformat'])?$setting_array[0]['setting_timeformat']:'',
               'membership' =>!empty($setting_array[0]['setting_membership'])?$setting_array[0]['setting_membership']:''
            ]);
    }
    
    public function getGeneral(){
        return $this->getIndex();
    }
    
    public function getUser(){
        
    }
    
    public function getSeo(){
        return $this->getIndex();
    }
    
    public function postIndex($view='admin.setting.index'){
        
        $input_params = $this->_request->all();
        $result = $this->validator($input_params);
        $setting = Setting::find(1);
        if(!$setting){
            $setting = new Setting();
        }
        
        if($result->passes()){
            
            $setting->setting_site_title = $input_params['site_title'];
            //$setting->setting_site_slogan= $input_params['site_slogan'];
            //$setting->setting_timeformat = $input_params['timeformat'];
            //$setting->setting_membership = $input_params['membership'];
            $setting->save();
            
            return view($view)
                ->withInput($this->_request->all())
                ->with([
                    'SuccessArray'   => array('msg'=>trans('admin.done') ),
                ]);
        }
        
        return view($view)
            ->withInput($this->_request->all())
            ->withErrors($result->getMessageBag());
    }
    
    public function postGeneral(){
        return $this->postIndex(); 
    }

    /*********/
    protected function validator( array $data, $type = null )
    {  

        switch( $type ){
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
                    'site_title'    => 'required|max:255',
                ]);
                break;

        }
    }
}
?>
