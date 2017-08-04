<?php

namespace Invetico\UserBundle\Validation;

use Arrow\Validation\Validation;


class ForgetPasswordFormValidation extends Validation
{
	public function register()
	{
		$this->add('email','Email',function($e){
	        $e->isRequire()
	          ->isEmail();
	    });
	}
}