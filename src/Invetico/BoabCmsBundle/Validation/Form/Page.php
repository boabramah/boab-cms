<?php

namespace Invetico\BoabCmsBundle\Validation\Form;

use Invetico\BoabCmsBundle\Validation\Form\Content;
use Invetico\BoabCmsBundle\Validation\ValidationInterface;
use Invetico\BoabCmsBundle\Validation\FormValidationInterface;

class Page extends Content implements FormValidationInterface
{
    public function register(ValidationInterface $validation)
    {
        parent::register($validation);
    }
}
