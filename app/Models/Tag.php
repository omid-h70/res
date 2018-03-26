<?php

namespace App\Models;


use DB ;


class Tag extends SuperClass
{
    
    static public $FOOD_TAG = "label";


    protected  $table = 'tags';
    protected  $primaryKey = 'tag_id';
    protected  $fillable = [
        'user_id',
        'tag_title',
        'tag_slug',
        'tag_type',
        'tag_status'
        
    ];
    

    /**
     * Many-to-Many relationship method.
     *
     * @return QueryBuilder
     */
    public function foods()
    {
        return $this->belongsToMany('App\Models\Food');
    }

}
