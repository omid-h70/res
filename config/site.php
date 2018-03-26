<?php

return [
    'site_title'   => 'محصول دمو',
    
    'fa_lang'      => 'fa',
    'en_lang'      => 'en',
    
    
    'registeredNamespaces'=>[
        'admin',
    ],
    
    // PermissionSeeder 
    
    'seederClasses'=>[
        RolesTableSeeder::class,
        PermissionsTableSeeder::class,
        UsersTableSeeder::class,
        CategoriesTableSeeder::class,
        SidebarsTableSeeder::class,
        ArticlesTableSeeder::class
    ],

    'registeredControllers' =>[
        //Admin NameSpace
        App\Http\Controllers\Admin\AclController::class,
        App\Http\Controllers\Admin\AdminController::class,
        App\Http\Controllers\Admin\ArticleController::class,
        App\Http\Controllers\Admin\FoodController::class,
        App\Http\Controllers\Admin\SettingController::class,
        //App\Http\Controllers\Admin\SidebarController::class,
        App\Http\Controllers\Admin\UserController::class,
        //
        App\Http\Controllers\ArticleController::class,
    ],
    
    'exceptionPermissions' =>[
        'setting_index',
        'setting_user'
    ],
    
];