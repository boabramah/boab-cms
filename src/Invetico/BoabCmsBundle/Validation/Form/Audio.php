<?php

namespace Invetico\BoabCmsBundle\Validation\Form;

use Invetico\BoabCmsBundle\Validation\Form\Content;
use Invetico\BoabCmsBundle\Validation\ValidationInterface;
use Invetico\BoabCmsBundle\Validation\FormValidationInterface;

class Audio extends Content implements FormValidationInterface
{
    public function register(ValidationInterface $validation)
    {
        parent::register($validation);

        $validation->add('audio_author', function ($e) {
            $e->setLabel('Author')
             ->isRequire();
        });

        $validation->add('audio_duration', function ($e) {
            $e->setLabel('Duration')
              ->isRequire();
        });
    }
}
