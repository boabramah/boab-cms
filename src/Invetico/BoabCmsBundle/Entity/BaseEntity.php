<?php

namespace Invetico\BoabCmsBundle\Entity;


abstract class BaseEntity
{
	protected $file;

	protected $order;

	protected $dateCreated;

	protected $datePublished;

	protected $owner;

	protected $uploadedThumbnail;

	protected $uploader;

	protected $dateformat = 'd-m-Y';


    public function getOrder()
	{
		return $this->order;
	}


	public function getDateCreated()
	{
		return $this->dateCreated;
	}


	public function getDatePublished()
	{
		return $this->dateCreated;
	}


	public function getOwner()
	{
		return $this->owner;
	}


	public function setFile($file)
	{
		$this->uploadedThumbnail = $file->get('thumbnail');
	}


    public function belongsTo($userId)
    {
        return (bool)($this->getUser()->getId() === $userId);
    }	

}