<?php

namespace Invetico\UserBundle\Validation;

use Invetico\BoabCmsBundle\Validation\ValidationInterface;
use Invetico\BoabCmsBundle\Validation\FormValidationInterface;
use Invetico\BoabCmsBundle\Validation\DataContextInterface;

class PasswordChange implements FormValidationInterface
{
	public function register(ValidationInterface $validation)
	{
		$validation->add('current_password','Current Password',function($e){
	        $e->isRequire();
	    });

	    $validation->add('password1','New Password',function($e){
	        $e->isRequire();
	    });

	    $validation->add('password2','Confirm Password',function($e){
	        $e->isRequire();
	    });
	}

}