<?php

namespace Invetico\BoabCmsBundle\EventListener;

use Invetico\BoabCmsBundle\Event\EntityEvent;

class EntityLifecycleListener
{
	public function __construct(){}

	public function onCleanup(EntityEvent $event)
	{
		$entity = $event->getEntity();

		if(is_callable([$entity, 'cleanup'])){
			$entity->cleanup();
		}
	}
}