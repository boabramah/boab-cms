<?php

namespace Invetico\BoabCmsBundle\Validation\Form;

use Arrow\Validation\Validation;

class MenuForm extends Validation
{
    public function register()
	{
        $this->add('menu_title','Title ',function($e){
            $e->isRequire();
        });

        $this->add('menu_path','Path ',function($e){
            $e->isRequire();

        });

	}
}