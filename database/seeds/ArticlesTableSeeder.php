<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


/**
 * Description of ArticlesTableSeeder
 *
 * @author Omid
 */
class ArticlesTableSeeder extends Seeder{
    //put your code here
    
    public function run(){
        
        $sth = '&lt;p&gt;به نام خدا&amp;nbsp;&lt;br&gt;به دموی سایت توکان خوش آمدید&lt;br&gt;این سیستم به صورت کاملا پویا و اختصاصی طراحی گشته است و پاسخگوی تمامی نیاز های شما خواهد بود&lt;br&gt;&lt;/p&gt;';
        //$clean_string = filter_var($sth, FILTER_SANITIZE_STRING);
        //$clean_string = preg_replace("/&#?[a-z0-9]{2,8};/i","",$sth);
        $temp =  html_entity_decode( $sth );
        $article_summary = substr( strip_tags($temp), 0, 100 );
        
        $hello_world_article = array( 
            
            'article_title'    => 'سلام دنیا',
            'article_slug'     => 'سلام_دنیا',
            'user_id'          => 1 ,           
            'article_body'     => $sth,
            'article_summary'  => $article_summary,
            'article_status'   => 'normal' ,
            
        );
        
        Article::create( $hello_world_article );
        
    }
}
