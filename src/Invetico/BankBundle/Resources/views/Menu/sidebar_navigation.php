<?php

    return [

    [
        'title'         =>'<span class="menu-icon glyphicon glyphicon-home"></span><p>Dashboard</p>',
        'description'   =>'Dashboard',
        'route_name'    => 'dashboard_area',
        'position'      =>1,
        'access_level'  =>'ROLE_USER'
    ],

    [
        'title'         =>'<span class="menu-icon glyphicon glyphicon glyphicon-folder-open"></span><p>Accounts</p>',
        'description'   =>'Account',
        'route_name'    => 'account_list',
        'position'      =>1,
        'access_level'  =>'ROLE_USER'
    ],

    [
        'title'         =>'<span class="menu-icon glyphicon glyphicon-briefcase"></span><p>Transfers</p>',
        'description'   =>'Funds Transfers',
        'route_name'    => 'transfers_list',
        'position'      =>1,
        'access_level'  =>'ROLE_USER'        
    ],
    [
        'title'         =>'Create Transfer',
        'description'   =>'Create Transfer',
        'route_name'    => 'transfers_list',
        'position'      =>2,
        'access_level'  =>'ROLE_USER'        
    ],
    [
        'title'         =>'Transfer History',
        'description'   =>'Transfer History',
        'route_name'    => 'transfers_history',
        'position'      =>2,
        'access_level'  =>'ROLE_USER'        
    ],              
    
    [
        'title'         =>'<span class="menu-icon glyphicon glyphicon-edit"></span><p>Services</p>',
        'description'   =>'Account Services',
        'route_name'    => 'account_services',
        'position'      =>1,
        'access_level'  =>'ROLE_USER'
    ],      

    [
        'title'         =>'<span class="menu-icon glyphicon glyphicon-envelope"></span><p>MailBox</p>',
        'description'   =>'Mailbox',
        'route_name'    => 'mailbox_inbox',
        'position'      =>1,
        'access_level'  =>'ROLE_ADMIN'        
    ],

    [
        'title'         =>'<span class="menu-icon glyphicon glyphicon-cog"></span><p>Settings</p>',
        'description'   =>'Settings',
        'route_name'    => 'settings_list',
        'position'      =>1,
        'access_level'  =>'ROLE_ADMIN'        
    ],

    [
        'title'         =>'<span class="menu-icon glyphicon glyphicon-cog"></span><p>Admin</p>',
        'description'   =>'Activity',
        'route_name'    => 'activity_index',
        'position'      =>1,
        'access_level'  =>'ROLE_ADMIN'        
    ],

    [
        'title'         =>'Accounts',
        'description'   =>'Account',
        'route_name'    => 'admin_account_index',
        'position'      =>2,
        'access_level'  =>'ROLE_ADMIN'        
    ],  

    [
        'title'         =>'Transfers',
        'description'   =>'Transfers',
        'route_name'    => 'admin_transfers_index',
        'position'      =>2,
        'access_level'  =>'ROLE_ADMIN'        
    ]                             





];
