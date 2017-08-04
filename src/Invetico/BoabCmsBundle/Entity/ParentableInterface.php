<?php

namespace Invetico\BoabCmsBundle\Entity;

interface ParentableInterface
{
	public function setParentId($parentId);

	public function getParentId();
}