<?php

namespace Invetico\UserBundle\Validation;

use Invetico\BoabCmsBundle\Validation\ValidationInterface;
use Invetico\BoabCmsBundle\Validation\FormValidationInterface;
use Invetico\BoabCmsBundle\Validation\DataContextInterface;


class AddUserValidation implements FormValidationInterface
{
	public function register(ValidationInterface $validation)
	{
		$validation->add('username',function($e){
	        $e->setLabel('Username')
			  ->isRequire();
	    });

		$validation->add('user_first_name',function($e){
			$e->setLabel('First Name')
	          ->isRequire();
	    });

		$validation->add('user_last_name',function($e){
			$e->setLabel('Last Name')
			  ->isRequire();
	    });	    	    

		$validation->add('email',function($e){
	        $e->setLabel('Email')
			  ->isRequire()
	          ->isEmail();
	    });

	    $validation->add('password',function($e){
			$e->setLabel('Password')
	          ->isRequire();
	    });

	    $validation->add('confirm_password',function($e){
			$e->setLabel('Confirm Password');
	        $e->isRequire();
	    });
	}

}

