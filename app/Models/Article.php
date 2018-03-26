<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB ;

class Article extends SuperClass
{
    /*
     * table_name and Primary Key
     */
    protected  $table = 'articles';
    protected  $primaryKey = 'article_id';
    
    protected $fillable = [
        'user_id',
        'article_title',
        'article_slug',
        'article_body',
        'article_summary',
        'article_status',
    ];
    
    /*
     * 
     */
    function __construct(array $attributes = array())
    {
        // TODO - Insert your code here
        parent::__construct($attributes);
    }
    
    public function checkArticleExists($title)
    {
        
        $result = Article::select('title')
            ->where('article_title',$title)
            ->get()->ToArray();

        if ( is_array( $result) ){
             return $result;
        }else{
            return FALSE;
        }        
    }
    
    public function getAllArticles(array $options = NULL)
    {

        $fields = array ('limit');
        $article_array = array();
        
        foreach( $fields as $field ){
            
            if ( !empty($options[$field]) ){
                
                switch( $field ){
                    
                    case'limit':
                        $article_array = Article::where('article_status','normal')
                            ->limit($options[$field])->orderBy($this->primaryKey, 'desc')
                            ->get()->toArray();   
                    break;
                   
                    default:

                    break;                 
                }
            }else{
                $article_array = Article::all()->toArray();
            }           
        }
    	return $article_array;
    }
    
    public function getArticle($article_id)
    { 
        $article_array = Article::firstOrNew(['article_id' => $article_id ])
    	   ->toArray();
	return $article_array ;
    }
    
    public function getArticleBy(array $article,$output = NULL)
    { 
        $fields = array ('article_id','article_slug');
        $article_array = array();
        
        foreach( $fields as $field ){
            
            if ( isset($article[$field]) ){
                
                switch( $field ){
                    
                    case'article_id':
                        $article_obj = Article::firstOrNew(['article_id' => $article['article_id'] ] );
                    break;
                    
                    case'article_slug':
                        $article_obj = Article::firstOrNew(['article_slug' => $article['article_slug'] ] );
                    break;
                    
                }
            }
            
        }
        if( empty($output) || $output == 'array' ){
            
            $article_array = $article_obj->toArray();
            return $article_array;
            
        }elseif( $output =='object' ){
            return $article_obj;
        }
    }
    
   

}

