<?php

namespace Invetico\UserBundle\Event;


class ProfileThumbnailUploadEvent extends BaseEvent
{
	private $request;


	public function setRequest($request)
	{
		$this->request = $request;
	}


	public function getRequest()
	{
		return $this->request;
	}

}