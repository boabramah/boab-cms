<?php

$menuItems = [
    [
        'title'         =>'<span class="navIcon fa fa-th-large"></span><span class="navLabel">Dashboard</span>',
        'description'   =>'Dashboard',
        'route_name'    => 'admin_dashboard',
        'position'      =>1,
        'access_level'  =>'ROLE_EDITOR'
    ],

    [
        'title'         =>'<span class="navIcon fa fa-cogs"></span><span class="navLabel">Menu</span>',
        'description'   =>'Menu Area',
        'route_name'    => 'menu_admin_index',
        'position'      =>1,
        'access_level'  =>'ROLE_SUPER_ADMIN'
    ],

    [
        'title'         =>'Add Item',
        'description'   =>'Add Item',
        'route_name'    => 'menu_admin_add',
        'position'      =>2,
        'access_level'  =>'ROLE_SUPER_ADMIN'
    ],     
    
    [
        'title'         =>'<span class="navIcon fa fa-files-o"></span><span class="navLabel">Content</span>',
        'description'   =>'Managing of content',
        'route_name'    => 'admin_content_list',
        'position'      =>1,
        'access_level'  =>'ROLE_USER'
    ],

    [
        'title'         =>'Add Content',
        'description'   =>'Adding content',
        'route_name'    => 'admin_content_add',
        'position'      =>2,
        'access_level'  =>'ROLE_EDITOR'        
    ]

];

return $menuItems;
