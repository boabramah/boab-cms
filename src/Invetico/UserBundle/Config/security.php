<?php

$access = new Invetico\UserBundle\Security\AccessControlCollection;

$access->add('^/adminxx',function($security){
	$security->isAuthenticated()
			 ->isGranted(['ROLE_EDITOR','ROLE_SUPER_ADMIN']);
			 //->ip('127.0.0.1');
});

$access->add('^/user/logout',function($security){
	$security->logout();
});

$access->add('^/user/login',function($security){
	$security->authenticate()
			 ->isAnonymous();
});

$access->add('^/account',function($security){
	$security->isAuthenticated();
});

$access->add('^/settings',function($security){
	$security->isAuthenticated();
});


$access->add('^/posting',function($security){
	$security->isAuthenticated();
});

return $access;