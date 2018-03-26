<?php

namespace App\Models;


use DB ;


class Time extends SuperClass
{
    static public $DAY_TYPE = "day";
    /*
     * table_name
     */
    protected  $primaryKey = 'time_id';
    protected  $table = 'times';
    protected  $fillable = ['time_title', 'time_slug', 'time_type'];
  
    
    /**
     *  Many To Many
     *
     *
     * @return QueryBuilder Object
     */
    public function foods()
    {
        return $this->belongsToMany('App\Models\Food');
    }


}
