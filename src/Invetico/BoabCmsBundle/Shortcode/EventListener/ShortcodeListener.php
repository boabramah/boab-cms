<?php
namespace Invetico\BoabCmsBundle\Shortcode\EventListener;

use Maiorano\Shortcodes\Manager\ShortcodeManager;
use Invetico\BoabCmsBundle\Controller\PublicControllerInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpFoundation\Response;
use Invetico\BoabCmsBundle\Controller\AdminControllerInterface;
 
class ShortcodeListener
{
	private $shortcodeManager;
	private $controller;
	
	public function __construct(ShortcodeManager $shortcodeManager)
	{
		$this->shortcodeManager = $shortcodeManager;
	}
    
    public function onKernelController(FilterControllerEvent $event)
    {
        $this->controller = $event->getController();
    }

	public function onKernelResponse(FilterResponseEvent $event)
	{

/*     	if (!is_array($this->controller) || !$this->controller[0] instanceof PublicControllerInterface) {
            return;
        }	
*/
        if($this->controller[0] instanceof AdminControllerInterface){
        	return;
        }
        $content = $event->getResponse()->getContent();
		if(!$this->shortcodeManager->hasShortcode($content)){
			return;
		}

		$content = $this->shortcodeManager->doShortcode($content, null, true);
		$response = $event->getResponse();
		$response->setContent($content);
		$event->setResponse($response);
	}

}