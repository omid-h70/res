<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;
use App\Http\Controllers\Admin\ArticleController as ArticleParent;
use Illuminate\Http\Request;

class ArticleController extends Controller{
    
    protected $_parent;

    public function __construct(Request $request){
        $this->_request = $request;
        return $this->_parent = new ArticleParent($request);
    }
    
    public function getIndex(){
        return $this->_parent->getIndex('article.index');
    }
    
    public function getShow(){
        return $this->_parent->getShow('article.show');
    }
}
