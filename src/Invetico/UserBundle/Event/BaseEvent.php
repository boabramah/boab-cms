<?php

namespace Invetico\UserBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class BaseEvent extends Event
{
	private $user;

	public function __construct(UserInterface $user)
	{
		$this->user = $user;
	}


	public function getUser()
	{
		return $this->user;
	}


	public function setUser(UserInterface $user)
	{
		$this->user = $user;
	}

}