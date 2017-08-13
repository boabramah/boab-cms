<?php

namespace Invetico\BoabCmsBundle\Validation\Form;

use Invetico\BoabCmsBundle\Validation\Form\Content;
use Invetico\BoabCmsBundle\Validation\ValidationInterface;
use Invetico\BoabCmsBundle\Validation\FormValidationInterface;

class Video extends Content implements FormValidationInterface
{
    public function register(ValidationInterface $validation)
    {
        parent::register($validation);

        $validation->add('youtube_video_id', function ($e) {
            $e->setLabel('Youtube video Id')
              ->isRequire();
        });
    }
}
