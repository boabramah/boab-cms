<?php

namespace Invetico\BoabCmsBundle\EventListener;

use Invetico\BoabCmsBundle\Library\Flash;
use Invetico\BoabCmsBundle\View\Template;

class FlashMessageListener 
{	
	private $flash;
	private $template;

	public function __construct(Flash $flash, Template $template) 
	{
		$this->flash = $flash;
		$this->template = $template;
    }

	public function onControllerEvent($event)
	{
		$this->template->bind('flash_error_messages', $this->flash->getErrorNotice(),true);
		$this->template->bind('flash_success_messages', $this->flash->getSuccesses(), true);
		$this->template->bind('flash_info_messages', $this->flash->getInfo(), true);
	}
}