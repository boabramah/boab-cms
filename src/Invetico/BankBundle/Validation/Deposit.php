<?php

namespace Invetico\BankBundle\Validation;

use Arrow\Validation\Validation;


class Deposit extends Validation
{
	public function register()
	{
		$this->add('paymentType','Payment Type',function($e){
	        $e->isRequire();
	    });

	    $this->add('amount','Amount',function($e){
	        $e->isRequire();
	    });
	}

}