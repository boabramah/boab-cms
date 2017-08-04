<?php

$oauthProvider = new Invetico\UserBundle\OAuthProvider\OAuthProviderCollection;

$oauthProvider->addProvider('bitly',function($oauth){
	$oauth->oauth_version="2.0";
	$oauth->dialogUrl = 'https://bitly.com/oauth/authorize?';
	$oauth->accessTokenUrl = 'https://api-ssl.bitly.com/oauth/access_token?';
	$oauth->responseType="code";
	$oauth->scope="";
	$oauth->state="";
	$oauth->userProfileUrl = "https://api-ssl.bitly.com/v3/user/info?";
	$oauth->header="";
});

$oauthProvider->addProvider('facebook',function($oauth){
	$oauth->provider="Facebook";
	$oauth->client_id = "484499591638881";
	$oauth->client_secret = "16b0060c97da7f2eeabb4e69dcac3a6d";
	$oauth->scope="email,publish_stream,user_photos,status_update,friends_online_presence,user_birthday,user_location,user_work_history";
	$oauth->redirect_uri  ="http://softmindia.com/user/oauth/facebook";

	$oauth->oauth_version="2.0";			
	$oauth->dialogUrl = 'https://www.facebook.com/dialog/oauth?client_id='.$oauth->client_id.'&redirect_uri='.$oauth->redirect_uri.'&scope='.$oauth->scope.'&state='.$oauth->state;
	$oauth->accessTokenUrl = 'https://graph.facebook.com/oauth/access_token';
	$oauth->responseType="code";
	$oauth->userProfileUrl = "https://graph.connect.facebook.com/me/?";
	$oauth->header="";
});

$oauthProvider->addProvider('google',function($oauth){
	$oauth->oauth_version="2.0";			
	$oauth->dialogUrl = 'https://accounts.google.com/o/oauth2/auth?';
	$oauth->accessTokenUrl = 'https://accounts.google.com/o/oauth2/token';
	$oauth->responseType="code";
	$oauth->userProfileUrl = "https://www.googleapis.com/oauth2/v1/userinfo?access_token=";
	$oauth->header="Authorization: Bearer ";	
});

$oauthProvider->addProvider('microsoft',function($oauth){
	$oauth->oauth_version="2.0";			
	$oauth->dialogUrl = 'https://login.live.com/oauth20_authorize.srf?';
	$oauth->accessTokenUrl = 'https://login.live.com/oauth20_token.srf';
	$oauth->responseType="code";
	$oauth->userProfileUrl = "https://apis.live.net/v5.0/me?access_token=";
	$oauth->header="";
});


return $oauthProvider;
