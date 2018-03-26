<?php
/*
 *  @author: Omid
 *  a Custom View Helper Class
 */
namespace app\Helpers ;

//use PersianCalender;
use Illuminate\Support\MessageBag;
use App\Libraries\htmlgen\HtmlGen as h;
use App\Models\User;
use App\Helpers\PersianCalender;
use App\Http\Controllers\Controller;

class Helper {
    
    protected $_style_type;
    protected static $_fa_lang = 'fa';
    protected static $_en_lang = 'en' ;
    
    
    public  function __construct() {
        
    }/** ENDOF __construct() */
    
    public static function getReady(){
         
    }
    
    public static function test(){
        
        $now = new \DateTime();
        $today = date("Y-m-d H:i:s");//mysql dateTime Format
        
        
        //#Test1
        //$persian_calender = new PersianCalender();
        //dd($persian_calender->mds_date('h:m:s'));
        
        //#Test2
        $fmt= new \IntlDateFormatter('fa', \IntlDateFormatter::TRADITIONAL , \IntlDateFormatter::TRADITIONAL,
                'Asia/Tehran',\IntlDateFormatter::TRADITIONAL);
        //dd( $fmt->format($now) );
        
        //++++++++++++++++++++++++++++++++++++++++++
        
        $fmt2= new \IntlDateFormatter('fa',  \IntlDateFormatter::NONE,  \IntlDateFormatter::NONE,
                'Asia/Tehran',\IntlDateFormatter::TRADITIONAL,'yyyy/MM/dd');
        
        echo( $fmt2->format($now) );
        dd();
         //++++++++++++++++++++++++++++++++++++++++++
        
        $fmt2 = new \IntlDateFormatter(
            'en_US',
            \IntlDateFormatter::FULL,
            \IntlDateFormatter::FULL,
            'America/Los_Angeles',
            \IntlDateFormatter::GREGORIAN,
            'MM/dd/yyyy'
        );

        //dd( $fmt2 );
        dd(  $fmt2->format(0) ); 
        
         
        $fmt = new \IntlDateFormatter( "en_US" ,\IntlDateFormatter::FULL, \IntlDateFormatter::FULL,
            'America/Los_Angeles',\IntlDateFormatter::GREGORIAN  );
        dd( 'It is now: "' . $fmt->format($now) . '" in Tokyo' . "\n"); 
        dd( $fmt->format('yyyy/MM/dd') ); // ۱۳۸۹/۰۲/۱۰
        echo $date->format('E dd LLL yyyy'); // جمعه ۱۰ اردیبهشت ۱۳۸۹
        dd();
        
    }
    
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++
    
    public static function createImageUrl( $image ,$options = NULL ){
        
        $keys = array('type');
        $fields = array_fill_keys( $keys ,'');
        $url = '';
        
        //dd( $fields );
        
        foreach( $fields as $key => $value ){
            
            if ( !empty($options[$key]) ){

                    switch( $key ){

                        case'type':

                            switch( $options[$key]){
                                
                                case 'thumb':
                                    $url =  url('public/images/thumbs/'.$image['picture_id'].'_'.$image['food_id'].'_thumb.'.$image['picture_ext'] ) ;
                                break;

                                case 'normal':

                                break; 
                            
                                default:
                                    //Normal Photo
                                    $url =  url('public/images/'.$image['picture_id'].'_'.$image['food_id'].'.'.$image['picture_ext'] ) ;
                                break;    

                            }

                        break;        
                    }
       
                
            }else{
                //Normal Photo
                $url =  url('public/images/'.$image['picture_id'].'_'.$image['food_id'].'.'.$image['picture_ext'] ) ;

            }
            
        }

    	return $url;

    }

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++
    
    public static function loadBootStrap( $lang ,$name_space = NULL)
    {
        if( $lang == self::$_fa_lang ){
            echo '<link href="'.url('public/bootstrap/rtl/bootstrap.min.css').'" rel="stylesheet">';
            
        }elseif ($lang == self::$_en_lang ){
            echo '<link href="'.url('public/bootstrap/ltr/bootstrap.min.css').'" rel="stylesheet">';   
        }
        return TRUE;
        
    }/** ENDOF loadBootStrap() */
    
    public static function loadStyleSheet( $lang ,$name_space = NULL)
    {
        /*
        switch ( $name_space ){
            case 'admin' :

            default:
                return FALSE;
        }
        */
        if( $lang == self::$_fa_lang ){
            echo '<link href="'.url('public/css/admin/rtl.css').'"  type="text/css" rel="stylesheet">';
            
        }elseif ($lang == self::$_en_lang ){
            echo '<link href="'.url('public/css/admin/ltr.css').'"  type="text/css" rel="stylesheet">';
        }
        return TRUE;
        
    }/** ENDOF loadStyleSheet() */
    
    public static function loadLocalFonts( $lang )
    {

        if( $lang == self::$_fa_lang ){
            
            h::link( array(
                'href'=>url('public/css/fa_font.css'),
                'rel'=>'stylesheet'
            ));    

        }elseif ($lang == self::$_en_lang ){
            
            h::link( array(
                'href'=>url('public/css/en_font.css'),
                'rel'=>'stylesheet'
            ));
            
        }
        return TRUE;

    }

    public static function modalBox( $type = NULL)
    {

        h::h1("Hello, World", array("class"=>"title"));
        
         h::comment("navigation");
         h::ul(array("class"=>"links"), function(){
            foreach(array(1,2,3) as $x)
                 h::li(function() use($x){
                     h::a("Link {$x}", "#{$x}");
                });
        });
 
    }
         
    public static function showErrors( $errors )
    {
        
        if( $errors instanceof  MessageBag  ){
            if( count($errors) > 0){
                echo '
                     <div class="col-sm-7 alert alert-danger alert-dismissible fade in">
                    ';
                foreach( $errors->all() as $error ){
                    echo '<li>'.$error.'</li>';
                    
                }
                echo '</ul>';
                echo '</div>';
                
            }
        }

    }/** ENDOF showErrors() */
    
    public static function showSuccess( $sucess_array )
    {

        if(!empty($sucess_array)){
            echo '
                 <div class="col-sm-7 alert bg-success alert-dismissible fade in">
            ';
            foreach($sucess_array as $success){
                echo '<li>'.$success.'</li>';

            }
            echo '</ul>';
            echo '</div>';

        }
        
    
    }/** ENDOF showErrors() */
    
    public static function formatTime( $time_str = NULL ,$options = NULL ){
        
        $fields = array ('format');
       
        if( is_null($options['format']) ){           
            $date_formater = 'Y:m:d' ;
            $time_formater = 'H:i:s' ;        
        }
              
        $temp_time = date($time_formater, strtotime($time_str ) );
        $temp_date = date($date_formater, strtotime($time_str ) );

        list($hour, $minute, $second) = explode(':', $temp_time);
        list($year, $month, $day)     = explode(':', $temp_date);

        $submitted_time = new \DateTime();
        $submitted_time->setDate($year, $month, $day);
        
        $formater= new \IntlDateFormatter( 'fa',  \IntlDateFormatter::NONE,  \IntlDateFormatter::NONE,
        'Asia/Tehran',\IntlDateFormatter::TRADITIONAL,'yyyy/MM/dd ');
        
        //dd( $formater->format($submitted_time) );
        
        $new_time_str = $formater->format($submitted_time).'-'.$hour.':'.$minute.':'.$second ;
        return( $new_time_str );
                        
    }
    
    public static function userHasPermission( $permission )
    {
        
        $user_object = new User();
        
        if( $user_object->can( $permission ) ){
            return TRUE;
        }
        
        return FALSE;
        
    }
    
    public static function getPermissionSlug($controller,$action=NULL){
        
        return Controller::getPermissionSlug($controller,$action);

    }
    
    
}
