<?php

namespace App\Models;

use DB;

class Url extends SuperClass
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'urls';
    protected $primaryKey = 'url_id';
    protected $fillable =['url_id','url_slug','url_title']  ;
    /*
    |--------------------------------------------------------------------------
    | Relationship Methods
    |--------------------------------------------------------------------------
    */
    
    public function getUrl( $url_id ){
    
        $result = Url::where('url_id','=',$url_id)
            ->get()->toArray();
        return $result[0];
    }
    
    public function getAllUrls( $depth_level = NULL ){

         
        $result = Url::select('urls.*')
            ->leftJoin('sidebar_url','urls.url_id','=','sidebar_url.url_id')
            ->where('url_depth_level','=',$depth_level)
            ->get()->toArray();
        
        dd( $result );
        $url_array = array();
        foreach ( $result as $key => $value ){
            $url_array[] = (array) $value;
        }
        
        dd( $url_array );
        return $url_array;
        
    }
    
    public function getChildUrls( $parent_id = NULL ){

        $result = DB::table('sidebar_url')
            ->where('url_parent_id','=',$parent_id)->get();
        foreach ( $result as $key => $value ){
            $url_array[] = (array) $value;
        }
        
        foreach( $url_array as $url ){
            $temp = Url::where('url_id','=',$url['url_id'])->get()->toArray();
            $child_url_array[] = $temp[0];
        }
        return $child_url_array;
        
    }
    
    public function checkUrlExists( $controller, $action, $namespace = null ){
    
        $url_object = Url::select('urls.url_slug')
            ->where('url_controller','=',$controller)
            ->where('url_slug','=',$action)
            ->first();    
            //->toSql();
        
        return $url_object;
    }
    
    public function setUrlOrder( array $data ){
        

        $result = DB::table('sidebar_url')
            ->where( 'sidebar_id','=',$data['sidebar_id'])
            ->where( 'url_id','=',$data['url_id'])
            ->update( [
                'url_child_order'  => $data['url_child_order'], 
                'url_parent_order' => $data['url_parent_order']               
            ]);
        return $result ;
    }

    /**
     * many-to-many relationship method
     *
     * @return QueryBuilder
     */
    public function sidebars()
    {
        return $this->belongsToMany('App\Models\Sidebars');
    }

}
