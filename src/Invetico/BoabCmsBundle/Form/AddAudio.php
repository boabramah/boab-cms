<?php

namespace Invetico\BoabCmsBundle\Form;

use Invetico\BoabCmsBundle\View\View;
use Invetico\BoabCmsBundle\View\Form\AddFormInterface;

class AddAudio extends View implements AddFormInterface
{
	public function getTemplate()
	{
		return 'BoabCmsBundle:Audio:add_audio';
	}
}