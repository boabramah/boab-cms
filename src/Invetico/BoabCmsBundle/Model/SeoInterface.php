<?php

namespace Invetico\BoabCmsBundle\Model;

interface SeoInterface
{
	public function getMetaTitle();


	public function getMetaDescription();


	public function getMetaAuthor();


	public function getMetaThumbnail();
}