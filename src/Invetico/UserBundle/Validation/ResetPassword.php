<?php

namespace Invetico\UserBundle\Validation;

use Arrow\Validation\Validation;


class ResetPassword extends Validation
{
	public function register()
	{
		$fields = ['password'=>'Password','confirm_password'=>'Confirm Password'];

		$this->set($fields, function($e){
	        $e->minLength(8);
	    });

	    $this->add('password', 'Password', function($e){
	    	$e->match($this->data['confirm_password'],'Both Password and Confirm Password do not match');
	    });

		/*
		$this->areRequire(
			'password'=>'Password',
			'confirm_password'=>'Confirm Password'
		);
		*/

		$this->set($fields, function($e){
				$e->isRequire();
		});
	}

}