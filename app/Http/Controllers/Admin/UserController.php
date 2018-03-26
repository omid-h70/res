<?php
namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;



/**
 *
 * @author Omid
 *        
 */
class UserController extends Controller
{
    protected $_request;

     // TODO - Insert your code here
    public function __construct( Request $request){
        $this->_request = $request;
        parent::__construct(['class_name'=>self::class]);
    }
    /**
     */
    
    public function getAddNew(){}
    
    public function getAll()
    {
        return $this->getIndex();
    }
    
    public function getEdit()
    {}
    
    public function getIndex()
    {
    
        $user = new User();
        $user_array = $user->getAllUsers();

        $role = new Role();
        $role_array = $role->getAllRoles();

        
        return view('admin.user.index')
            ->with([
                'user_array'=> $user_array ,
                'role_array'=> $role_array    
            ]);
        // TODO - Insert your code here
    }
    
    public function postAddNew()
    {
        if( $this->_request->ajax() ) {

            $input_params = $this->_request->all();
            
            //dd( $input_params );
            
            
            if( !empty($input_params['id']) ){
                
                $user = User::Find($input_params['id']);
                if(!empty($input_params['email'])){
                    if($input_params['email']!= $user->user_email){
                        $data['user_email'] = $input_params['email'];     
                    }
                }
                
                $fields = array('id','password','role');
                foreach($fields as $field ){
                    if(!empty($input_params[$field])){
                        $data['user_'.$field] = $input_params[$field];
                    }
                }
                $result = $this->validator($data,'edit_user');
                if($result->passes()){
                    $data['user_email'] = $input_params['email'];
                    $data['user_role']  = $input_params['role_select'];//Edit it man ,wtf is this ?
                }
                
            }else{
                
                $user = new User();

                $data = array(
                    'user_email'      => $input_params['email'],
                    'user_password'   => $input_params['password'],
                    'user_password_confirmation' => $input_params['password_confirmation'],
                    'user_role'       => $input_params['role_select'],
                );
                $result = $this->validator($data);
                
            }

            if( $result->fails() ){

                $response = $result->getMessageBag()->toArray();
                return response()->json( $response );

            }

            $user_role = array ();
            $user_role['role_slug'] = $input_params['role_select'];

            //dd($data);
            $result = $user->registerUser($data, $user_role);

            if( $result ){
                $response =['no-error'=>trans('admin.done')];
                return response()->json( $response );
            }

        }

     }

    public function postEdit()
    {
        if( $this->_request->ajax() ) {

            $input_params = $this->_request->all();
            $action = !empty($input_params['action'])?$input_params['action']:'';

            switch( $action ){
                
                case 'update_status':
                    
                    $data = array(
                        'user_id'      => $input_params['user_id'],
                        'user_status'  => $input_params['user_status'],
                        'user_role'    => (!empty($input_params['user_role'])?$input_params['user_role']:'') ,
                    );
                    
                    $result = $this->validator( $data, 'update_status');
                    if( $result->fails() ){
                
                        $response = $result->getMessageBag()->toArray();
                        return response()->json( $response );

                    }
                        
                    $user = new User();
                    $result =$user->updateUser($data);

                    if( $result ){
                        $response =['no-error'=>trans('admin.done')];
                        return response()->json( $response );
                    }
                    
                break;
                    
                default:
                    $data = array(
                        'user_id'  => $input_params['user_id'],
                    );
                    
                    $result = $this->validator($data,'edit_user');
                    
                    if( $result->fails() ){
                        $response = $result->getMessageBag()->toArray();
                        return response()->json( $response );
                    }
                        
                    $user = User::Find($data['user_id']);

                    if( $user ){
                        $response =[
                            'id'    => $user->user_id,
                            'email' => $user->user_email
                        ];
                        return response()->json( $response );
                    }
                    
                    $response =['error'=>trans('admin.database_error')];
                    return response()->json( $response );
                    
                break;
            }

        }else{
            
            
            
        }
    }
    
    protected function validator(array $data, $mode = NULL)
    {
    
        switch($mode){
            
            case 'edit_user':
                return Validator::make($data, [
                    'user_email'      => 'unique:users|email|max:255',
                    'user_password'   => 'confirmed|min:6',
                ]);
            break;
        
            case'update_status':
                
                return Validator::make($data, [
                    'user_id'    =>  'required|numeric',
                    'user_status' => 'required',

                ]);
                
            break;
            
            default:
                return Validator::make($data, [
                    'user_first_name' => 'max:255',
                    'user_email'      => 'unique:users|required|email|max:255',
                    'user_password'   => 'required|confirmed|min:6',
                ]);
            break;
            
            
        }
        
    }
    
}
