<?php

namespace Invetico\BankBundle\Validation;

use Arrow\Validation\Validation;


class Payment extends Validation
{
	public function register()
	{
		$this->add('current_password','Current Password',function($e){
	        $e->isRequire();
	    });

	    $this->add('password1','New Password',function($e){
	        $e->isRequire();
	    });

	    $this->add('password2','Confirm Password',function($e){
	        $e->isRequire();
	    });
	}

}