<?php

namespace Invetico\BoabCmsBundle\Form;

use Invetico\BoabCmsBundle\View\View;
use Invetico\BoabCmsBundle\View\Form\EditFormInterface;

class EditPage extends View implements EditFormInterface
{
    public function getTemplate()
    {
        return 'BoabCmsBundle:Admin:edit_page';
    }
}
