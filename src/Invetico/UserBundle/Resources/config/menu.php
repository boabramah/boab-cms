<?php

return [
	
	[
		'title'			=>'<span class="navIcon fa fa-user"></span><span class="navLabel">Users</span>',
		'description'	=>'User Area',
		'route_name'	=> 'admin_user_index',
		'position'      =>1,
		'access_level'  => 'ROLE_SUPER_ADMIN'
	],
	[
		'title'			=>'Add User',
		'description'	=>'Add User',
		'route_name'	=> 'user_add',
		'position'      =>2,
		'access_level'  => 'ROLE_SUPER_ADMIN'
	],	

];