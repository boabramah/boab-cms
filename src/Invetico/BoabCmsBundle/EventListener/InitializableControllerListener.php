<?php

namespace Invetico\BoabCmsBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Invetico\BoabCmsBundle\Controller\InitializableControllerInterface;

class InitializableControllerListener
{
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof InitializableControllerInterface) {
            $controller[0]->initialize();
        }
    }
}