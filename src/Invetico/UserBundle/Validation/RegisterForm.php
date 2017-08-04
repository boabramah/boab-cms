<?php

namespace Invetico\UserBundle\Validation;

use Arrow\Validation\Validation;


class RegisterForm extends Validation
{
	public function register()
	{
		$this->add('username','Username',function($e){
	        $e->isRequire();
	    });

		$this->add('email','Email',function($e){
	        $e->isRequire()
	          ->isEmail();
	    });

	    $this->add('password','Password',function($e){
	        $e->isRequire();
	    });

	    $this->add('confirm_password','Confirm Password',function($e){
	        $e->isRequire();
	    });

	    $fields= [
			'username'=>'Username',
			'email'=>'Email',
			'password'=>'Password',
			'confirm_password'=>'Confirm Password'
			'contact_number' => 'Contact Number',
			'constituency'=>'Constituency'
		];

		$this->areRequire($fields);
	}

}