<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use App\Models\Food;
use App\Models\Role;
use App\Models\Time;
use App\Models\Tag ;
use App\Models\Picture ;
use App\Models\Notification;
use App\Helpers\Helper;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;

//++++++++++++++++++++++++++ Imagin Libarary

//use Imagine\Imagick\Imagine ;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Gd\Imagine;


/**
 *
 * @author Omid
 *        
 */
class FoodController extends Controller{

    // TODO - Insert your code here
    
    private   $_image_json_obj_cache;
    
    protected $_request;
    protected $_images_path ='/uploads/images/'; //++++ Use a Symbolic Link or What 
    protected $_images_thumbs_path ='/uploads/images/thumbs/'; //++++ Use a Symbolic Link or What 
    protected $_category_type = 'food';
    protected $_view_params ;
    /**
     *
     */
    protected $_permission_role_array =[ 
        0 => [
            'role_title'  => 'Cook',
            'role_slug'   => 'cook',
            //'role_status' => Role::$NORMAL_STATUS
        ]
    ];
    
    protected $_controller  = 'food';
    protected $_namespace   = 'admin';
    
    protected $_url_action_array =[
        'url_title'=>'Food',
        'url_slug' =>'food',
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
     
    
    /**
     * // TODO - Insert your code here
     */
    function __construct(Application $app, Request $request){
        $this->_request = $request;
        $this->_app = $app;
        $_permission_role_array[0]['role_staus'] = Role::$NORMAL_STATUS;
        parent::__construct(['class_name'=>self::class]);
    }
    /**
     * 
     * @return 
     */
    public function getIndex(){

        /**** showing gelAll() result ****/
        return $this->getAll(); 

    }
    /**
     * 
     */
    public function getAddNew(){
 
        /**
         * Response to GET request .../admin/food/add-new
         */
        $image_json_obj = array();
        
        $category = new Category();
        $category_array = $category->getCategoryTitles('food');

        //dd(  $category_array );
        
        return view('admin.food.add-new')->with([
            'category_array' => $category_array,
            'image_json_obj'=> json_encode( $image_json_obj ,JSON_PRETTY_PRINT),
        ]);
    }
    /**
     * 
     * @param unknown $post_params
     */
    public function postAddNew(){

        $category = new Category();
        $image_json_obj = $data = array();
        
        $category_array = $category->getCategoryTitles('food');
        $view_params['category_array'] = $category_array;

        if( $this->_request->ajax() ) {

            $input_params = $this->_request->all();

            $data = array('category_title' => $input_params['category_title'] );
            $category_validation = $this->validator( $data , 'category_title' );

            if( $category_validation->passes() ){

                $category = new Category();
                $category->category_title  = trim($input_params['category_title']);
                $category->category_slug   = mb_strtolower( str_replace(' ', '_', trim($input_params['category_title']) ) ) ;
                $category->category_type   = $this->_category_type;
                $category->category_status = Category::$NORMAL_STATUS;
                $result = $category->save();
                
                $user = new User();
                $user->user_id = auth()->user()->getAuthIdentifier() ;
                
                $result = $user->categories()->save( $category );
               
                if( $result ){
                    
                    $category = new Category();
                    $category_array = $category->getLastCategoryTitles('food');
                    
                    $response = [
                        'no-error'       => trans('admin.done'),
                        'category_array' => $category_array
                    ];
                    
                    return response()->json( $response );
                    
                }else{
                    
                    $response = [
                        'error' => trans('admin.database_error'),
                    ];
                    
                    return response()->json( $response ); 
                    
                }

           }else{ 
                $response = $category_validation->getMessageBag()->toArray();
                return response()->json( $response );
           }
            
            
        } else { /************_POST Request*******************/

            $locale = $this->_request->getLocale();
            $input_params = $this->_request->all();
            
            $data['food_title']    = $input_params['food_title'];
            
            if( $input_params['category_select']!='none' ){
                $data['category_slug'] = $input_params['category_select'];
            }else{
                $data['category_slug'] = '';
            }
            
            $data['food_price']    = $input_params['food_price'];
            $data['picture_input'] = $this->_request->file('picture_input');

            //dd( $data );
            $result = $this->validator( $data );

        
            if( $result->fails() ){

                $this->_request->flash();

                return view('admin.food.add-new')
                    ->withInput($this->_request->all())
                    ->with([
                        'category_array' =>$view_params['category_array'],
                        'image_json_obj'=> json_encode( $image_json_obj ,JSON_PRETTY_PRINT),
                    ])
                    ->withErrors( $this->validator( $data )->getMessageBag() );

            
            }elseif( $result->passes() ){

                $data = [
                    'food_title'    => $input_params['food_title'] ,
                    'category_slug' => $input_params['category_select'],
                    'food_price'    => $input_params['food_price'],
                    'food_status'   => !empty($input_params['food_status'])?$input_params['food_status']:'',
                    'picture_input' => !empty($input_params['picture_input'])?$input_params['picture_input']:'',
                    'category_title'=> $input_params['category_title'],
                    'time_array'    => !empty($input_params['day_array'])?$input_params['day_array']:'',
                    'tag_array'     => !empty($input_params['tag_array'])?$input_params['tag_array']:'',
                ];
                //dd($data);

                $result = $this->saveFood( $data );

                if( !$result ){

                    return view('admin.food.add-new')
                        ->with('ViewParams', $view_params)
                        ->with([
                            'category_array'=>$view_params['category_array'] ,
                            'image_json_obj'=> json_encode( $this->_image_json_obj_cache ,JSON_PRETTY_PRINT),
                        ]);
                        //->withErrors( $result );

                }elseif( $result ){
                    
                    return view('admin.food.add-new')
                        ->with([
                            'SuccessArray'   => array('msg'=>trans('admin.done') ),
                            'ViewParams'     => $view_params,
                            'category_array' => $view_params['category_array'],
                            'image_json_obj'=> json_encode( $this->_image_json_obj_cache ,JSON_PRETTY_PRINT),
                        ]);
                }


            }

        }
    }
    /**
     * 
     */

    public function getAll(){

        $food_object = new Food();
        $picture_object = new Picture();
        
        $food_array = $food_object->getAllFoods();
        $food_paginator = $this->paginator( $food_array );
                
        
        $tag_array = $picture_array = array();
        
        //dd( $food_array );
        foreach( $food_array as $food ){
           $tag_array[$food['food_id']]     = $food_object->getFoodTags( $food['food_id'] ); 
           $picture_array[$food['food_id']] = $picture_object->getPictureBy( array('food_id'=>$food['food_id']) );  
        }
    
        $food_tag_array     = $tag_array ;
        $food_picture_array = $picture_array;
        //dd( $tag_array );

        return view('admin.food.all')
            ->with([
                'food_paginator'      => $food_paginator ,
                'food_tag_array'      => $food_tag_array ,
                'food_array'          => $food_array ,
                'food_picture_array'  => $food_picture_array,
            ]);
    }
    /**
     * 
     */

    public function postAll(){

    }
    /**
     * 
     */
    public function getEdit(){
        
        
        $locale = $this->_request->getLocale();
        $input_params = $this->_request->all();
        
        $image_json_obj = array();

        if( $this->_request->ajax() ) {

            
        }else{

            $food_id = $this->_request->get('id') ;

            if( isset($food_id) && $food_id!=NULL){

                $food = new Food();
                $category = new Category();

                $food_array = $food->getFoodById( $food_id );
                /**Check ?**/
                $category_array1 = $food->getFoodCategories( $food_array['food_id']);
                $category_array2 = $category->getCategoryTitles('food');
                
                $tag_array       = $food->getFoodTags( $food_array['food_id']);
                $time_array      = $food->getFoodTimes( $food_array['food_id']);
                $picture_array   = $food->getFoodPictures( $food_array['food_id']);

                if(!empty( $category_array1) ){

                    $find = array();
                    foreach( $category_array2 as $key1 => $temp ){
                        foreach ( $category_array1[$food_id] as $key2 => $temp2){
                            if( $temp['category_slug'] == $temp2['category_slug']){
                                $category_array2[$key1]['selected'] = TRUE;
                               //$find[$key]['category_title'] = $temp['category_title'] ;
                               //$find[$key]['category_slug'] = $temp['category_slug'] ;
                            }
                        }

                    }
                    $selected_category_array = $category_array2 ;

                }

                //dd( $selected_category_array );

                if(!empty( $time_array) ){
                    $find = array();
                    foreach ( $time_array[$food_id] as $key => $time){
                        $find[$time['time_slug']] = $time; 
                    }
                    $time_array = $find ;
                }


                if(!empty( $tag_array) ){

                    $find = array();
                    foreach ( $tag_array[$food_id] as $key => $tag){
                        $find[] = $tag['tag_title']; 
                    }
                    $find = implode(",",$find);
                    $tags = $find ;
                }

                if( !empty( $picture_array ) ){
    
                    foreach ( $picture_array[$food_id] as $key => $picture){
                        
                        $image_json_obj['href'] = Helper::createImageUrl( $picture ,['type'=>'thumb']); 
                        $image_json_obj['id']   = $picture['picture_id'];
                                
                    }

                }
                $this->_image_json_obj_cache = $image_json_obj ;
                $this->_request->flash();

                //dd( $image_json_obj );

                return view('admin.food.edit')
                    ->with([

                        'food_id'        => $food_id,
                        'food_title'     => $food_array['food_title'],
                        'food_price'     => $food_array['food_price'],
                        'category_array' => !empty($selected_category_array)?$selected_category_array:'',  
                        'image_json_obj'=> json_encode( $this->_image_json_obj_cache ,JSON_PRETTY_PRINT),
                        //'picture_array'  => !empty($picture_array)?$picture_array:'',
                        'tag_array'      => !empty($tags)?$tags:'',
                        'time_array'     => $time_array,

                    ]);
            }

        }
        
        
    }
    
    /************_POST Request*******************/

    public function postEdit(){

        $locale = $this->_request->getLocale();
        $input_params = $this->_request->all();
        
        $image_json_obj = array();
        
        if( $this->_request->ajax() ) {
            
            $action = $input_params['action'];
            
            switch( $action ){
                
                case'update_food':
                    
                    $food = new Food();
                    $food_array = array(
                        'food_id' => $input_params['food_id'] ,
                        'food_status' => $input_params['food_status'] ,
                    );
                    
                    $result = $this->updateFood($food_array);
                    if(+$result){
                        $response = ['no-error'=>trans('admin.done')];
                    }else{
                        $response = ['error'=>trans('admin.database_error')];
                    }
                break;
                
            }
            return response()->json( $response ); 
            
            
        }else{
            
            /************non-ajax request**********************/
            $food_id = $input_params['food_id'] ;
            
            if( !empty($food_id )){
                
                $data['food_title']    = $input_params['food_title'];

                if( $input_params['category_select']!='none' ){
                    $data['category_slug'] = $input_params['category_select'];
                }else{
                    $data['category_slug'] = '';
                }    

                $data['food_price']    = $input_params['food_price'];
                $data['picture_input'] = $this->_request->file('picture_input');

                $category = new Category();
                $category_array = $category->getCategoryTitles('food');

                $result = $this->validator( $data ,'edit_food');

                $this->_request->flash();
                
                if( $result->fails() ){

                    return view('admin.food.edit')
                        ->with([
                            'category_array' => $category_array,
                            'image_json_obj'=> json_encode( $this->_image_json_obj_cache ,JSON_PRETTY_PRINT),
                        ])
                        ->withInput( $this->_request->all() )
                        ->withErrors( $this->validator( $data ,'edit_food' )
                        ->getMessageBag() 
                    );


                }elseif( $result->passes() ){
           
                    $data = array();

                    $data = [
                        'food_id'       => $input_params['food_id'],
                        'food_title'    => $input_params['food_title'] ,
                        'category_slug' => $input_params['category_select'],
                        'food_price'    => $input_params['food_price'],
                        'food_status'   => !empty($input_params['food_status'])?$input_params['food_status']:'',
                        'picture_input' => !empty($input_params['picture_input'])?$input_params['picture_input']:'',
                        'time_array'    => !empty($input_params['day_array'])?$input_params['day_array']:'',
                        'tag_array'     => !empty($input_params['tag_array'])?$input_params['tag_array']:'',
                        'image_json_obj'=> json_encode( $this->_image_json_obj_cache ,JSON_PRETTY_PRINT),

                    ];

                    $result = $this->saveFood( $data );

                    if( !$result ){

                        return view('admin.food.add-new')
                            ->with( [
                                'category_array' => $view_params['category_array'],
                                'food_id'        => $food_id,
                                'image_json_obj'=> json_encode( $this->_image_json_obj_cache ,JSON_PRETTY_PRINT),
                                ])
                            ->withErrors( $result );

                    }elseif( $result ){

                        return view('admin.food.add-new')
                            ->with([
                                'SuccessArray'   => array('msg'=>trans('admin.done')),
                                'ViewParams'     => '',
                                'category_array' => !empty($view_params['category_array'])?$view_params['category_array']:$category_array,
                                'image_json_obj'=> json_encode( $this->_image_json_obj_cache ,JSON_PRETTY_PRINT),
                            ]);
                    }

                }
            }
        }
        /******** if( $result ) *********/
    }
    
    protected function saveFood( array $input_array ){

        $food_name = $input_array['food_title'];
        $category = new Category();
        $picture  = new Picture();
        
        $category_array = $category->getCategoryBy( 
            array('category_slug' =>$input_array['category_slug'] 
        ));
        //dd( $category_array );
            
        $user = new User();
        $user->user_id = auth()->user()->getAuthIdentifier() ;
        
        if( !empty($input_array['food_id']) ){
            $food    = Food::find( $input_array['food_id']);
        }else{
            $food    = new Food(); 
        }
        
        $food->food_title  = trim($input_array['food_title']);
        $food->food_slug   = mb_strtolower( str_replace(' ', '_', trim($input_array['food_title']) ) ) ;
        $food->food_price  = $input_array['food_price'];

        empty( $input_array['food_status'] )?$food->food_status = Food::$DEACTIVE_STATUS:$food->food_status = $input_array['food_status'];

        //dd($food->food_status.'::::array:::'.$input_array['food_status']);
        
        $new_food = $user->foods()->save( $food );
            
        if( $new_food ){
            
            $notify = new Notification();
            $notify->notification_owner     = 'food';
            $notify->notification_owner_id  = $new_food->food_id;
            $notify->notification_slug      = 'add_food';
            $notify->notification_title     = 'food.new_added';
            $notify->save();
            
            $result = $food->categories()->sync([ $category_array['category_id'] ]);
        }

        $file = $this->_request->file('picture_input');

        if( !empty($file) ){

            $picture->food_id        = $new_food->food_id;
            $picture->picture_title  = $food->food_title;
            $picture->picture_slug   = mb_strtolower( str_replace(' ', '_', trim($food->food_title) ) );

            $upload_success = $this->uploadFoodPhoto( $file ,$picture );
            
        }    
        
        /*************** Time Handeling***************************/
        $sync_array = array();
            
        if( $result ){

            if( !empty( $input_array['time_array'] ) ){

                $time_array = $input_array['time_array'];
                //dd($time_array);

                foreach ($time_array as $time){

                    if( isset($time) && $time!=null){

                        $new_time = Time::firstOrCreate( array(
                            'time_title' => trim($time),
                            'time_slug'  => mb_strtolower( str_replace(' ', '_', trim($time) ) ),
                            'time_type'  => Time::$DAY_TYPE,
                        ) );      

                        $sync_array[] = $new_time->time_id;
                    }


                }
                $result =  $food->times()->sync( $sync_array );
            }

            /************** Tag Handeling ****************/

            if( !empty($input_array['tag_array']) ){


                $tag_array = $input_array['tag_array'];

                $tag_array = explode(',',  $tag_array);

                foreach ($tag_array as $tag){

                   if( isset($tag) && $tag!=null){

                        $new_tag = Tag::firstOrCreate( array(
                           'user_id'    => auth()->user()->getAuthIdentifier(),
                           'tag_title'  => trim($tag),
                           'tag_slug'   => mb_strtolower( str_replace(' ', '_', trim($tag) ) ),
                           'tag_type'   => Tag::$FOOD_TAG,
                           'tag_status' => 'active',
                        ) );

                        $sync_array[] = $new_tag->tag_id;

                    }
                    
                }
                $result =  $food->tags()->sync( $sync_array );

            } /******** if(isset($tag_array) *********/
            
            return TRUE;


        }/******** if( $result ) *********/

    }
    
    protected function updateFood(array $food_array){
        
        $food = Food::find( $food_array['food_id'] );
        $food->food_id = $food_array['food_id']; 
        $result = '';
        
        if( $food->food_status != $food_array['food_status'] ){
            
            $food->food_status = $food_array['food_status'];
            $result = $food->save();
            
            if( $result ){
                return TRUE;
            }    
            return FALSE;
        }
        
       return TRUE;
    }
    
    protected function uploadFoodPhoto( $file, Picture $picture ){

        $dir = storage_path().$this->_images_path ;
        $thumb_dir = storage_path().$this->_images_thumbs_path ;
        $picture_array = $image_json_obj = array();
        
  
        if( !empty($file) ){

            if (!file_exists($dir) && !is_dir($dir)) {
                mkdir($dir);
                chmod($dir,0777);
            }
            
            if (!file_exists($thumb_dir ) && !is_dir($thumb_dir )) {
                mkdir($thumb_dir );
                chmod($thumb_dir ,0777);
            }

            $ext = $file->getClientOriginalExtension();
            $temp = $picture->getPictureBy( ['food_id'=>$picture->food_id ] );
            
            //dd($temp);
            
            if(!empty($temp)){
                $temp_obj = Picture::find( $temp[0]['picture_id'] );
                $temp_obj->food_id        = $picture->food_id;
                $temp_obj->picture_title  = $picture->picture_title;
                $temp_obj->picture_slug   = $picture->picture_slug;
                $picture = $temp_obj ;
            }
            
            $picture->user_id        = auth()->user()->getAuthIdentifier();
            $picture->picture_ext    = $ext;
            $picture->picture_type   = Food::$LABEL;
            $picture->picture_status = Picture::$NORMAL_STATUS;

            //$result = Picture::firstOrCreate($picture);
            $result = $picture->save();
            
            //dd($result);
            if( $result ){
                
                $temp['picture_id']  = $picture->picture_id ;
                $temp['food_id']     = $picture->food_id ;
                $temp['picture_ext'] =  $ext;
                
                $image_json_obj['href'] = Helper::createImageUrl( $temp ,['type'=>'thumb']); 
                $image_json_obj['id']   = $picture['picture_id'];
                $this->_image_json_obj_cache = $image_json_obj ;

                $file_name = $picture->picture_id.'_'.$picture->food_id ;
                $path = $dir.$file_name.'.'.$ext;
                $thumb_path = $thumb_dir.$file_name.'_thumb.'.$ext;
                
                $upload_success = $file->move($dir, $file_name.'.'.$ext);
                //dd( $dir.'/'.$file_name.'.'.$ext );
                //var_dump( $dir.'/'.$file_name.'.'.$ext );
                $imagine = new Imagine();
                $imagine->open($path)
                        ->resize(new Box(320, 240))
                        ->save($path);
                
                $imagine->open($path)
                        ->resize(new Box(100, 100))
                        ->save($thumb_path);
                
                
            }

            return $result ;
            
        }  
        
        
        
    }

    protected function validator( array $data,  $type = null ){

        switch ( $type ){
            case'picture_input':
                return Validator::make($data, [
                    'picture_input'      => 'image|max:10000',
                ]);
            break;

            case'tag_input':
                return Validator::make($data, [
                    'tag_input'      => 'max:100',
                ]);
            break;

            case'category_title':
                return Validator::make($data, [
                    'category_title'      => 'unique:categories|required|max:255',
                ]);
            reak;
             
            case 'edit_food':
                return Validator::make($data, [
                     'food_title'         => 'required|max:255',
                     'category_slug'      => 'required|max:255',
                     'picture_input'      => 'image|max:10000',
                     'food_price'         => 'numeric',
                     
                ]);
            break;
            
            default:   

                return Validator::make($data, [
                    'food_title'         => 'unique:foods|required|max:255',
                    //'food_title'         => 'required|max:255',
                    'category_slug'      => 'required|max:255',
                    'picture_input'      => 'image|max:10000',
                    'food_price'         => 'numeric',
                     
                ]);
            break;
                
        }
        
    }
    
    /********/

}

?>
