<?php

namespace Invetico\BoabCmsBundle\Validation\Form;

use Invetico\BoabCmsBundle\Validation\ValidationInterface;
use Invetico\BoabCmsBundle\Validation\FormValidationInterface;

class Content implements FormValidationInterface
{
    public function register(ValidationInterface $validation)
    {
        $validation->add('page_title', function ($e) {
            $e->setLabel('Title')
              ->isRequire();
        });

        $validation->add('page_summary', function ($e) {
            $e->setLabel('Summary')
              ->isRequire();
        });

        $validation->add('page_body', function ($e) {
            $e->setLabel('Body')
              ->isRequire();
        });

        if ($validation->get('menu_enable')) {
            $validation->add('menu_title', function ($e) {
                $e->setLabel('Menu title')
                  ->isRequire();
            });
        }

    }
}
