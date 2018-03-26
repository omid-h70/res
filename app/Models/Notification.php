<?php

namespace App\Models;

use DB;

class Notification extends SuperClass
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notifications';
    protected $primaryKey = 'notification_id';

    
    public function getAllNotifications()
    {
        $notification_array  =  Notification::limit(5)->get()->toArray();
        return $notification_array ;

    }
    
    /*
    |--------------------------------------------------------------------------
    | Relationship Methods
    |--------------------------------------------------------------------------
    */
    /**
     * many-to-many relationship method
     *
     * @return QueryBuilder
     */
    public function food()
    {
        return $this->belongsToMany('App\Models\Food');
    }
        /**
     * many-to-many relationship method
     *
     * @return QueryBuilder
     */
    public function permission()
    {
        return $this->belongsToMany('App\Models\Permission');
    }
        /**
     * many-to-many relationship method
     *
     * @return QueryBuilder
     */
    public function picture()
    {
        return $this->belongsToMany('App\Models\Picture');
    }
        /**
     * many-to-many relationship method
     *
     * @return QueryBuilder
     */
    public function role()
    {
        return $this->belongsToMany('App\Models\Role');
    }
    /**
     * many-to-many relationship method
     *
     * @return QueryBuilder
    */
    public function sidebar()
    {
        return $this->belongsToMany('App\Models\Sidebar');
    }
     /**
     * many-to-many relationship method
     *
     * @return QueryBuilder
     */
    public function tag()
    {
        return $this->belongsToMany('App\Models\Role');
    }
    /**
     * many-to-many relationship method
     *
     * @return QueryBuilder
     */
    public function time()
    {
        return $this->belongsToMany('App\Models\Time');
    }
    /**
     * many-to-many relationship method
     *
     * @return QueryBuilder
     */
    public function url()
    {
        return $this->belongsToMany('App\Models\Url');
    }
    /**
    * many-to-many relationship method
    *
    * @return QueryBuilder
    */
    public function user()
    {
        return $this->belongsToMany('App\Models\User');
    }

}

?>