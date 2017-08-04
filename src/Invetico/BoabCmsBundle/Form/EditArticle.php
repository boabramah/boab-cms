<?php

namespace Invetico\BoabCmsBundle\Form;

use Invetico\BoabCmsBundle\View\View;
use Invetico\BoabCmsBundle\View\Form\EditFormInterface;

class EditArticle extends View implements EditFormInterface
{
    public function getViewFile()
    {
        return 'BoabCmsBundle:Page:edit_page';
    }
}
