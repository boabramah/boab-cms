<?php

namespace Invetico\BoabCmsBundle\Validation\Form;

use Arrow\Validation\Validation;

class Content extends Validation
{
    public function register()
    {
        $this->add('page_title','Title',function ($e) {
            $e->isRequire();
        });

        $this->add('page_summary','Summary',function ($e) {
            $e->isRequire();
        });

        $this->add('page_body','Body ',function ($e) {
            $e->isRequire();
        });

        if ($this->get('menu_enable')) {
            $this->add('menu_title','Menu title ',function ($e) {
                $e->isRequire();
            });
        }

    }
}
