<?php

namespace Invetico\BankBundle\Validation;

use Arrow\Validation\Validation;


class Search extends Validation
{
	public function register()
	{
	    $this->add('account_number','Account Number',function($e){
	        $e->isRequire();
	    });
	}

}