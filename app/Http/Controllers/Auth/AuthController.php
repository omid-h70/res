<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\MessageBag;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Redirector;




class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    
    protected $_default_role   = 'guest';
    protected $redirectPath    = '/admin';
    protected $loginPath       = 'auth/login';


    public function __construct(Application $app, Redirector $redirector, Request $request)
    {       
        parent::__construct();
        $this->middleware('guest', ['except' => 'getLogout']);
    }
    
    
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function register(array $post_data)
    {
        /**
         * based On Eloquent: Relationships Model
         * 
         */
    	$user = new User();
        
    	$user_array = [
            //'user_first_name' => $post_data['name'],
            'user_password'   => $post_data['user_password'] ,
            'user_email'      => $post_data['user_email'],
    	];

    	$result = $user->registerUser( $user_array );
        
        if( $result ){
            return TRUE;
        }
        
    }
        
	/*
	 * 
	 */
    public function getLogin(){
    	return view( 'auth.login');
    }
    /*
     * 
     */
    public function getLogout( Request $request ){
    	Auth::logout();
    	return redirect('login');
    }
    /*
     * 
     */
    public function getRegister( Request $request ){
	return view('auth.register'); 	
    }
    /*
     * 
     */
    public function postLogin( Request $request)
    {
    	$locale = $request->getLocale();
    	$input_params = $request->all();
    	
    	if ( isset($input_params['remember']) ){
            $remember = 1;
    	}else{
            $remember = 0;
    	}

        $credentials = [
            'user_email'     => $input_params['user_email'],
/**!!!!!**/ 'password'       => $input_params['user_password'],/* Actual Field is ' user_password '*/
            'user_status'    => User::$NORMAL_STATUS /* the User cannt Enter if the Account is not Activated*/
        ];
     
    	if( Auth::attempt($credentials,$remember) ){
            
            //dd( $input_params['user_password'].'    '.bcrypt($input_params['user_password']) );
            return redirect()->intended()->with(['message'=>'logged in !']);
    		
    	}else{
            $errors = new MessageBag(['login_error'=>'login_ credentials_error']);
            return view('auth.login')->withErrors( $errors );
     	}
    }
    
    /*
     * 
     */
    public function postRegister( Request $request ){

    	$data = $request->all();
        //dd($data);
    	$result = $this->validator($data);	
    	if( $result->fails() ){
            return view('auth.register')->withErrors( $this->validator($data)->getMessageBag() );
    	}else{
            $new_user = $this->register($data);
            return redirect('/')->with(['reg_msg'=>'successful_reg']) ;
    	}
    	
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            //'user_name'     => 'required|max:255',
            'user_email'    => 'unique:users|required|email|max:255',
            'user_password' => 'required|confirmed|min:6',
        ]);
    }


}
