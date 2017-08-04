<?php

namespace Invetico\BoabCmsBundle\Helper;

use Invetico\BoabCmsBundle\Event\EntityEvent;

trait EventDispatcherHelper
{
	public function trigger($entity, $eventType)
	{
		$event = new EntityEvent($entity, $this->request);
		$this->eventDispatcher->dispatch("entity.pre_$eventType", $event);

		$entity = $event->getEntity();

		$this->save($entity);
		$this->entityManager->refresh($entity);

		$event->setEntity($entity);
		$this->eventDispatcher->dispatch("entity.post_$eventType", $event);	
		return $event->getEntity();
	}
}