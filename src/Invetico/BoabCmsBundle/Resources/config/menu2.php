<?php

return [
	
	[
		'title'			=>'<span class="navIcon fa fa-cogs"></span><span class="navLabel">Menu</span>',
		'description'	=>'Menu Area',
		'route_name'	=> 'menu_admin_index',
		'position'      =>1,
		'access_level'  =>'ROLE_SUPER_ADMIN'
	],

	[
		'title'			=>'Add Item',
		'description'	=>'Add Item',
		'route_name'	=> 'menu_admin_add',
		'position'      =>2,
		'access_level'  =>'ROLE_SUPER_ADMIN'
	]
];
