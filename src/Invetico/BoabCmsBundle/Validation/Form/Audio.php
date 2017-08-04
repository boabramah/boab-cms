<?php

namespace Invetico\BoabCmsBundle\Validation\Form;

use Invetico\BoabCmsBundle\Validation\Form\Content;

class Audio extends Content
{
    public function register()
	{
        parent::register();
        
        $this->add('audio_Author','Author ',function($e){
            $e->isRequire();
        });    

        $this->add('audio_duration','Duration',function($e){
            $e->isRequire();
        });         
	}
}