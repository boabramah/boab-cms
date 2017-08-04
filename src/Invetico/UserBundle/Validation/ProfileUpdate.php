<?php

namespace Invetico\UserBundle\Validation;

use Arrow\Validation\Validation;


class ProfileUpdate extends Validation
{
	public function register()
	{
		$this->add('user_first_name','First Name',function($e){
	        $e->isRequire();
	    });

	    $this->add('user_last_name','Last Name',function($e){
	        $e->isRequire();
	    });

	    $this->add('user_email','Email',function($e){
	        $e->isRequire()
	          ->isEmail();
	    });
	}

}