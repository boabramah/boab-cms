<?php

namespace Invetico\BoabCmsBundle\Validation\Form;

use Invetico\BoabCmsBundle\Validation\Form\Content;

class Video extends Content
{
    public function register()
    {
        parent::register();

        $this->add('youtube_video_id','Youtube video Id',function ($e) {
            $e->isRequire();
        });

    }
}
