<?php
namespace app\Helpers ;


use Illuminate\Support\MessageBag;
use App\Libraries\htmlgen\HtmlGen as h;
use Illuminate\Support\Facades\App;


class ViewPlugin{
    
    protected $_parent_key ;
    
    public static function loadPluginScripts( $plugin_name ){
        
        switch ( $plugin_name ){
            
            case 'jQuery-File-Upload':
                h::script( array("src"=>url( "/public/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js") ) );
                h::script( array("src"=>url( "/public/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js") ) );
                h::script( array("src"=>url( "/public/plugins/jquery-file-upload/js/JavaScript-Canvas-to-Blob/canvas-to-blob.min.js") ) );
                h::script( array("src"=>url( "/public/plugins/jquery-file-upload/js/JavaScript-Load-Image/load-image.all.min.js") ) );
                h::script( array("src"=>url( "/public/plugins/jquery-file-upload/js/JavaScript-Templates/tmpl.min.js") ) );
                h::script( array("src"=>url( "/public/plugins/jquery-file-upload/js/jquery.iframe-transport.js") ) );
                h::script( array("src"=>url( "/public/plugins/jquery-file-upload/js/jquery.fileupload.js") ) );
                h::script( array("src"=>url( "/public/plugins/jquery-file-upload/js/jquery.fileupload-process.js") ) );
                h::script( array("src"=>url( "/public/plugins/jquery-file-upload/js/jquery.fileupload-image.js") ) );
                h::script( array("src"=>url( "/public/plugins/jquery-file-upload/js/jquery.js/jquery.fileupload-validate.js") ) );
                h::script( array("src"=>url( "/public/plugins/jquery-file-upload/js/jquery.js/jquery.fileupload-ui.js") ) );
                h::script( array("src"=>url( "/public/plugins/jquery-file-upload/js/jquery.js/main.js") ) );

                break;
        }
        
        
        
    }
    
    public static function loadPluginStyles( $plugin_name ){
    
    
        switch ( $plugin_name ){
        
            case 'jQuery-File-Upload':
                h::link( array("href"=>url( "/public/plugins/jquery-file-upload/css/jquery.fileupload.css") ) );
                h::link( array("href"=>url( "/public/plugins/jquery-file-upload/css/jquery.fileupload-ui.css") ) );
                h::link( array("href"=>url( "/public/plugins/jquery-file-upload/css/style.css") ) );
                /*******
                 * <!-- CSS adjustments for browsers with JavaScript disabled -->
                 * <noscript><link rel="stylesheet" href="css/jquery.fileupload-noscript.css"></noscript>
                 * <noscript><link rel="stylesheet" href="css/jquery.fileupload-ui-noscript.css"></noscript>
                 * 
                 * 
                 * **/
                break;
        }
    
    
    }
    
}