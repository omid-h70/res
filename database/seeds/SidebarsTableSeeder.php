<?php

use App\Models\Sidebar;
use App\Models\Url;
use App\Models\Role;
use Illuminate\Database\Seeder;


class SidebarsTableSeeder extends Seeder
{
    protected $_child_url_icon_class = 'fa-link';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $role = new Role();
	$role->role_id = 1;

	//$sidebar = '';	
        $sync_array = '';
	
        $sidebar_array = array( 
            'user_id'         => 1 , /******* Root User *********/
            'sidebar_title'   => 'Root',
            'sidebar_slug'    => 'root',
            'sidebar_type'    => 'sidebar',
            'sidebar_status'  => 'active'
        );

	$sidebar = Sidebar::create( $sidebar_array ) ;
	$sidebar->roles()->sync( ['role_id'=>$role->role_id]);
        
        //++++++++++++++++++++++++++++++++++++++
        //++ First Create the Root Sidebar  Assign it to SuperUser Role
        //++ Then Seed it with 'Root Sidebar'
        //++
        //++++++++++++++++++++++++++++++++++++++
        
            
        $sidebar_array =[
//            0 => array(
//                'url_title'       => 'admin.dashboard',
//                'url_slug'        => 'admin',
//                'url_namespace'   => 'admin',
//                'url_controller'  => 'admin' ,
//                'url_icon_class'  => 'fa-dashboard',
// 
//            ),
            1 => array(
                'url_title'       => 'acl.acl',
                'url_slug'        => 'acl',
                'url_namespace'   => 'admin',
                'url_controller'  => 'acl' ,
                'url_icon_class'  => 'fa-key',
                
                'children'=>[
//                    0 =>[
//                        'url_title'       => 'acl.add_new',
//                        'url_slug'        => 'add-new',
//                        'url_icon_class'  => $this->_child_url_icon_class ,
//                    ],
                    0 =>[
                        'url_title'       => 'acl.see_all',
                        'url_slug'        => 'all',
                        'url_icon_class'  => $this->_child_url_icon_class ,
                    ]
                ]  
            ),
            2 => array(
                'url_title'       => 'user.user',
                'url_slug'        => 'user',
                'url_namespace'   => 'admin',
                'url_controller'  => 'user' ,
                'url_icon_class'  => 'fa-users',
                
                'children'=>[
                    0 =>[
                        'url_title'       => 'user.see_all',
                        'url_slug'        => 'all',
                        'url_icon_class'  => $this->_child_url_icon_class ,
                    ]
                ]  
            ),
            3 => array(
                'url_title'       => 'food.food',
                'url_slug'        => 'food',
                'url_namespace'   => 'admin',
                'url_controller'  => 'food' ,
                'url_icon_class'  => 'fa-leaf' ,
                
                'children'=>[
                    0 =>[
                        'url_title'       => 'food.add_new',
                        'url_slug'        => 'add-new',
                        'url_icon_class'  => $this->_child_url_icon_class ,
                    ],
                    1 =>[
                        'url_title'       => 'food.see_all',
                        'url_slug'        => 'all',
                        'url_icon_class'  => $this->_child_url_icon_class ,
                    ]
                ]  
            ), 
            //++++++++++++++++++++++++++++++++ if needed in a project bring it back !
//            4 => array(
//                'url_title'       => 'sidebar.sidebar',
//                'url_slug'        => 'sidebar',
//                'url_namespace'   => 'admin',
//                'url_controller'  => 'sidebar' ,
//                'url_icon_class'  => 'fa-sitemap',
//                
//                'children'=>[
//                    0 =>[
//                        'url_title'       => 'sidebar.add_new',
//                        'url_slug'        => 'add-new',
//                        'url_icon_class'  => $this->_child_url_icon_class ,
//                    ],
//                    1 =>[
//                        'url_title'       => 'sidebar.see_all',
//                        'url_slug'        => 'all',
//                        'url_icon_class'  => $this->_child_url_icon_class ,
//                    ]
//                ]  
//            ),
            //</++++++++++++++++++++++++++++++++ if needed in a project bring it back ! >
            
            5 => array(
                'url_title'       => 'article.article',
                'url_slug'        => 'article',
                'url_namespace'   => 'admin',
                'url_controller'  => 'article' ,
                'url_icon_class'  => 'fa-pencil-square-o',
                
                'children'=>[
                    0 =>[
                        'url_title'       => 'article.add_new',
                        'url_slug'        => 'add-new',
                        'url_icon_class'  => $this->_child_url_icon_class ,
                    ],
                    1 =>[
                        'url_title'       => 'article.see_all',
                        'url_slug'        => 'all',
                        'url_icon_class'  => $this->_child_url_icon_class ,
                    ]
                ]  
            ),
            6 => array(
                'url_title'       => 'setting.setting',
                'url_slug'        => 'setting',
                'url_namespace'   => 'admin',
                'url_controller'  => 'setting' ,
                'url_icon_class'  => 'fa-cogs',
                
                'children'=>[
                    0 =>[
                        'url_title'       => 'setting.general',
                        'url_slug'        => 'general',
                        'url_icon_class'  => $this->_child_url_icon_class ,
                    ],
                    1 =>[
                        'url_title'       => 'setting.seo',
                        'url_slug'        => 'seo',
                        'url_icon_class'  => $this->_child_url_icon_class ,
                    ],
                    2 =>[
                        'url_title'       => 'setting.user',
                        'url_slug'        => 'user',
                        'url_icon_class'  => $this->_child_url_icon_class ,
                    ]
                ]  
            )
        ];

        if( !empty( $sidebar_array ) ){

            $sidebar = new Sidebar();
            $sidebar = Sidebar::find(1);
            $parent_id = '';
            $order = 1 ;

            foreach( $sidebar_array as $key => $parent_url ){
                
                $parent_url_obj = new Url();

                if( !$parent_url_obj ->checkUrlExists( $parent_url ['url_controller'], $parent_url['url_slug'] ) ){

                    $parent_url_obj->url_slug       = $parent_url ['url_slug'] ;
                    $parent_url_obj->url_title      = $parent_url ['url_title'] ;
                    $parent_url_obj->url_controller = $parent_url ['url_controller'] ;
                    $parent_url_obj->url_namespace  = $parent_url ['url_namespace']; 
                    $parent_url_obj->url_icon_class = $parent_url ['url_icon_class']; 

                    $result = $parent_url_obj->save();
                    if($result){
                        $sidebar->urls()->attach( [$parent_url_obj ->url_id=>[
                            'url_parent_id'   => 0, // its a Parent !
                            'url_depth_level' => 1,
                            'url_order'       => $order
                        ]]); 
                    }
                    $parent_id = $parent_url_obj->url_id;
                    $i = 0 ;

                    if( !empty( $parent_url['children'] ) ){
                        
                        $children = $parent_url['children'] ;

                        foreach ( $children as $child_key => $child_url ){
                            $i++;
                            $url_obj = new Url();

                            if( !$url_obj->checkUrlExists( $parent_url ['url_controller'], $child_url['url_slug'] ) ){

                                $url_obj->url_slug       = $child_url['url_slug'] ;
                                $url_obj->url_title      = $child_url['url_title'] ;
                                $url_obj->url_controller = $parent_url['url_controller'] ;
                                $url_obj->url_namespace  = $parent_url['url_namespace'] ;
                                $url_obj->url_icon_class = $child_url['url_icon_class'] ;
                                $result = $url_obj->save();

                                $sidebar->urls()->attach( [
                                    $url_obj->url_id=>[
                                        'url_parent_id'   => $parent_id,
                                        'url_depth_level' => 2 ,
                                        'url_order'       => ++$order
                                    ] 

                                ]);

                            }
                        }//End Of foreach
                    }//End Of if(!empty( $parent_url['children'] ) )
                }

            }//End Of foreach($sidebar_array



        }    

    }
    
    ////
}
