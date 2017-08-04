<?php

namespace Invetico\BankBundle\Validation;

use Arrow\Validation\Validation;


class Customer extends Validation
{
	public function register()
	{
		$this->add('accountName','Account Name',function($e){
	        $e->isRequire();
	    });

	    $this->add('accountNumber','Account Number',function($e){
	        $e->isRequire();
	    });
	}

}