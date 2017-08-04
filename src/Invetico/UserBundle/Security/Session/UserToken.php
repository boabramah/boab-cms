<?php

namespace Invetico\UserBundle\Security\Session;

use Invetico\UserBundle\Entity\User;

class UserToken
{
	private $id;
	private $lastName;
	private $username;
	private $thumbnail;
	private $contactNumber;
	private $email;
	private $country;
	private $locationId;


	public function __construct(User $user)
	{
		$this->setUser($user);
	}


	public function setUser(User $user)
	{
		$this->id = $user->getId();
		$this->lastName = $user->getLastName();
		$this->thumbnail = $user->getThumbnailPath();
		$this->username = $user->getUsername();
		$this->contactNumber = $user->getContactNumber();
		$this->email = $user->getEmail();
		$this->country = $user->getCountry()->getName();
		$this->locationId = $user->getCountry()->getId();
	}


	public function getLastName()
	{
		return $this->lastName;
	}


	public function getId()
	{
		return $this->id;
	}


	public function getUsername()
	{
		return $this->username;
	}


	public function getThumbnail()
	{
		return $this->thumbnail;
	}


	public function getContactNumber()
	{
		return $this->contactNumber;
	}


	public function getEmail()
	{
		return $this->email;
	}


	public function getCountry()
	{
		return $this->country;
	}


	public function getLocationId()
	{
		return $this->locationId;
	}
}