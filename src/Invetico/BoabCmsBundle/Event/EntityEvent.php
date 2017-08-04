<?php

namespace Invetico\BoabCmsBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

class EntityEvent extends Event
{
	private $entity;

	public function __construct($entity, Request $request)
	{
		$this->entity = $entity;
		$this->request = $request;
	}


	public function getEntity()
	{
		return $this->entity;
	}


	public function setEntity($entity)
	{
		$this->entity = $entity;
	}


	public function getRequest()
	{
		return $this->request;
	}

}