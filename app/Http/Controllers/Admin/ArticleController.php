<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator ;
use App\Models\Article ;
use App\Models\Picture ;
use App\Helpers\Helper;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;



class ArticleController extends Controller{

    const NORMAL_STATUS ='normal';
    const ATTACHED_TYPE ='a';
 
    protected $_dest_path ='/uploads';
    protected $_request;
    protected $_images_path ='/uploads/images/articles/'; //++++ Use a Symbolic Link or What 
    protected $_images_thumbs_path ='/uploads/images/thumbs/'; //++++ Use a Symbolic Link or What 
    private   $_file_object ;
    
    public function __construct(Request $request){
        $this->_request = $request;
        $this->_namespace_slug = 'admin';
        parent::__construct(['class_name'=>self::class]);
    }

    public function getAddNew()
    {
    	return view('admin.article.add-new');
    }
    
    public function getAll()
    {
        $article_object = new Article();
        $article_array = $article_object->getAllArticles();

        $article_paginator = $this->paginator( $article_array );
        
//        foreach( $article_array as $key => $article ){
//            $article_array[$key]['created_at'] = Helper::formatTime( $article['created_at'] ); 
//            $article_array[$key]['updated_at'] = Helper::formatTime( $article['updated_at'] ); 
//        }

        return view('admin.article.all')
            ->with([
                'article_paginator'      => $article_paginator ,
                'article_array'          => $article_array ,
            ]);
        
    }
    
    public function getIndex($view='admin.article.add-new')
    {
    	return view($view);
    }
    
    public function getEdit($view='admin.article.edit'){
        
        $article_id = $this->_request->get('id') ;
        
        if(!empty($article_id)){
            
            $article = new Article();
            $article_array = $article->getArticleBy(['article_id'=>$article_id]);

            if(!empty($article_array)){

            }   
            //dd($article_array['article_title']);
            $this->_request->flash();
            return view($view)
                ->with([
                    'article_id'     => $article_id,
                    'article_title'  => $article_array['article_title'],
                    'article_body'   => $article_array['article_body'],
                ]);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getShow($view='admin.article.show')
    {
        $request = $this->_request;
        $article_id = $request->get('id');
        $article_object = new Article();

        if( !empty($article_id) ){
        
            switch ($mode){
                default:                    
                    $article_array = array();
                    if(is_numeric( $article_id ) ){
                        $article_array = $article_object->getArticle( $article_id );
                    }
                    $article_array['article_body'] = htmlspecialchars_decode( $article_array['article_body'] );

                break;
            }


            return view($view)->with([
                'article_array'=> $article_array,
            ]);
        
        }
    }

    
    public function postAddNew()
    {
        if( $this->_request->ajax() ){
            
            //Handeling Ajax Requests for Uploading extra Contents 
            
            $input_params = $this->_request->all();
            if(!empty($input_params['request'])){
                $request = $input_params['request'];
            }else{
                $request='photo_upload';
            }
            
            switch($request){
                
                case'photo_upload':
                    //Image upload Request
                    $data = $this->_request->file();
                    $file = $data['file'];

                    $article_object = new Article();
                    $id = $article_object->getLastInsertedId();

                    $dir = storage_path().$this->_images_path;
                    $this->_file_object = $file;

                    $file_name = $file->getClientOriginalName();
                    if (!file_exists($dir) && !is_dir($dir)) {

                        mkdir($dir);
                        chmod($dir,0777);

                    }

                    $ext = $file->getClientOriginalExtension(); 
                    $upload_success = $file->move( $dir, $file_name );

                    $response = [
                        'no-error' => trans('admin.done'),
                        'img_name' => $file_name,
                        'img_url'  => url('public/images/articles/'.$id.'_'.$file_name )

                    ];

                break;

            }    
            return response()->json( $response ); 
            
        }else{
            
            $locale = $this->_request->getLocale();
            $input_params = $this->_request->all();

            $result = $this->validator($input_params);
            
            //$temp_data[]
            //dd( $input_params ['article_body']);
             
            if( $result->fails() ){
                
                $this->_request->flash();
                
                return view('admin.article.add-new')
                    ->withInput( $this->_request->all() )
                    ->withErrors( $result->getMessageBag() );
                
            }else if($result->passes()){
                
                //to do more modification 
                // remove html specialChar

                $article_summary = substr( strip_tags($input_params['article_body']), 0, 100 );


                $temp_data = [
                    'user_id'           =>auth()->user()->getAuthIdentifier(),
                    'article_title'     =>$input_params['article_title'],
                    'article_slug'      =>mb_strtolower( str_replace(' ', '_', trim($input_params['article_title']) ) ),
                    'article_body'      =>$input_params['article_body'],
                    'article_summary'   =>$article_summary,
                    'article_status'    =>self::NORMAL_STATUS,                            
                ];
                
                $result = $this->saveArticle( $temp_data );
                
                if( $result ){
                    
                    return view('admin.article.add-new')
                        ->with([
                            'SuccessArray'   => array('msg'=>trans('admin.done') ),
                        ]);
                }
            }
            
            
        }
        
    }
    
    public function postEdit($view='admin.article.edit')
    {
        if( $this->_request->ajax() ){
            
            //Handeling Ajax Requests for Uploading extra Contents 
            
            $input_params = $this->_request->all();
            $request = $input_params['request'];
            //dd($request.':::'.$input_params);
           
            switch($request){
                
                case'update_article':

                    $article_array = array(
                        'article_id'     => $input_params['article_id'] ,
                        'article_status' => $input_params['article_status'] ,
                    );
                    $result = $this->updateArticle( $article_array );
                    if( $result ){
                        $response = ['no-error'=>trans('admin.done')];
                    }else{
                        $response = ['error'=>trans('admin.database_error')];
                    }
                break;
            }
  
            return response()->json( $response ); 
            
        }else{
            
            $locale = $this->_request->getLocale();
            $input_params = $this->_request->all();
            $this->_request->flash();
            
            $temp_obj = new Article();
            $temp = $temp_obj->getArticleBy(['article_id'=>$input_params['article_id']]);
            if($temp['article_title']==$input_params['article_title']){
                $result = $this->validator($input_params,'edit_article');
            }else{
                 $result = $this->validator($input_params);
            }
            //$temp_data[]
            //dd( $input_params ['article_body']);

            if($result->passes()){
                
                //to do more modification 
                // remove html specialChar

                $article_summary = substr( strip_tags($input_params['article_body']), 0, 100 );

                $temp_data = [
                    'article_id'        =>$input_params['article_id'],
                    'user_id'           =>auth()->user()->getAuthIdentifier(),
                    'article_title'     =>$input_params['article_title'],
                    'article_slug'      =>mb_strtolower( str_replace(' ', '_', trim($input_params['article_title']) ) ),
                    'article_body'      =>$input_params['article_body'],
                    'article_summary'   =>$article_summary,
                    'article_status'    =>self::NORMAL_STATUS,                            
                ];
                
                $result = $this->saveArticle( $temp_data );
                //dd($this->_request->all());
                if($result){
                    
                    return view($view)
                        ->withInput( $this->_request->all() )
                        ->with([
                            'SuccessArray'   => array('msg'=>trans('admin.done') ),
                        ]);
                }
            }

            return view($view)
                ->withInput( $this->_request->all() )
                ->withErrors($result->getMessageBag() );
            
        }
        
        
    }

    public function saveArticle( array $article){
        
        if(!empty($article['article_id'])){
            $article_obj = Article::find($article['article_id']);
        }else{
            $article_obj = new Article();
        }
        
        $article_obj->article_title = $article['article_title'];
        $article_obj->article_slug  = $article['article_slug'];
        $article_obj->article_body  = htmlspecialchars($article['article_body']);
       
        
        $result = $article_obj->save();
        return $result ;
        
    }

    /**
     * updateArticle the specified resource in storage.
     *
     * @param  array $article_array
     * @return TRUE/FALSE
     * 
     */
    public function updateArticle(array $article_array)
    {
        $article = Article::find( $article_array['article_id'] );
        $article->article_id = $article_array['article_id']; 
        $result = '';
        
        if( $article->article_status != $article_array['article_status'] ){
            $article->article_status = $article_array['article_status'];
            $result = $article->save();
            if($result){
                return TRUE;
            } 
            return FALSE;
        }
 
        return TRUE;
    }

    protected function validator(array $data,$type = null){

        switch ( $type ){
           
            case 'edit_article':
                return Validator::make($data, [  
                    'article_title'      => 'required|max:255',
                    'article_body'       => 'required|max:10000',  
                ]);
            break;
            
            default:   
                return Validator::make($data, [
                    'article_title'      => 'unique:articles|required|max:255',
                    'article_body'       => 'required|max:10000',                     
                ]);
            break;
                
        }
        
    }
    /********/


}
