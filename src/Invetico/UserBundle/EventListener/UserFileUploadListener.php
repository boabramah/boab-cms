<?php

namespace Invetico\UserBundle\EventListener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Bundle\BoabCmsBundle\Event\EntityEvent;
use Invetico\BoabCmsBundle\Entity\FileUploadInterface;
use Invetico\BoabCmsBundle\EventListener\BaseFileUploadListener;
use Invetico\UserBundle\Event\ProfileThumbnailUploadEvent;
use Invetico\UserBundle\Event\AccountRegisteredEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class UserFileUploadListener extends BaseFileUploadListener
{
	protected $allowedExt = ['png','jpg'];
	protected $savedFile = [];
	
	public function onUploadProfileThumbnail(ProfileThumbnailUploadEvent $event)
	{
		
		$entity = $event->getUser();
		$file = $this->getFileUploaded('thumbnail');
		if(!$entity instanceof UserInterface || !$entity instanceOf FileUploadInterface || null == $file){	
			return;
		}


		$oldThumbnail = $entity->getUploadRoot() . '/' . $entity->getThumbnail();

		$this->validateFileType($file);		
		$generatedFileName = $this->generateFileName($file);
		$destination = $entity->getUploadRoot().'/'.$generatedFileName;

		$this->upload($file, $destination);

		$entity->setThumbnail($generatedFileName);
		$event->setUser($entity);

		$this->deleteFile($oldThumbnail);
	}


	public function onPreAccountRegister(EntityEvent $event)
	{
		$entity = $event->getEntity();
		$file = $this->getFileUploaded('user_thumbnail');
		if(!$entity instanceof UserInterface || !$file instanceof UploadedFile){
			return;
		}

		$this->validateFileType($file);

		$oldThumbnail = $entity->getUploadRoot() . '/' . $entity->getThumbnail();		
		$generatedFileName = $this->generateFileName($file);
		
		$this->savedFile = compact('oldThumbnail', 'generatedFileName');
		$entity->setThumbnail($generatedFileName);
	}


	public function onAccountRegister(AccountRegisteredEvent $event)
	{
		$user = $event->getUser();
		$file = $this->getFileUploaded('thumbnail');
		if(!$user instanceof FileUploadInterface || !$file instanceof UploadedFile){
			return;
		}

		$this->validateFileType($file);		
		$generatedFileName = $this->generateFileName($file);
		$destination = $user->getUploadRoot().'/'.$generatedFileName;

		$this->upload($file, $destination);

		$user->setThumbnail($generatedFileName);
		$event->setUser($user);
	}


}
