<?php

namespace Invetico\UserBundle\Validation;

use Invetico\BoabCmsBundle\Validation\ValidationInterface;
use Invetico\BoabCmsBundle\Validation\FormValidationInterface;
use Invetico\BoabCmsBundle\Validation\DataContextInterface;


class Register implements FormValidationInterface
{
	public function register(ValidationInterface $validation)
	{
		$validation->add('username','Username',function(DataContextInterface $e){
	        $e->isRequire();
	        //$e-;
	    });

		$validation->add('user_first_name','First Name',function(DataContextInterface $e){
	        $e->isRequire();
	    });

		$validation->add('user_last_name','Last Name',function(DataContextInterface $e){
	        $e->isRequire();
	    });	    	    

		$validation->add('email','Email',function(DataContextInterface $e){
	        $e->isRequire()
	          ->isEmail();
	    });

	    $validation->add('password','Password',function(DataContextInterface $e){
	        $e->isRequire();
	    });

	    $validation->add('confirm_password','Confirm Password',function(DataContextInterface $e){
	        $e->isRequire();
	    });
	}

}

