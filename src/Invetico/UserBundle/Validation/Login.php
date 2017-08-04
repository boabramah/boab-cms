<?php

namespace Invetico\UserBundle\Validation;

use Arrow\Validation\Validation;


class Login extends Validation
{
	public function register()
	{
		$this->add('email','Email',function($e){
	        $e->isRequire()
	          ->isEmail();
	    });

	    $this->add('password','Password',function($e){
	        $e->isRequire();
	    });
	}

}