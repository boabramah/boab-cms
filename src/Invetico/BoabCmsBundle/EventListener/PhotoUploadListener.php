<?php

namespace Invetico\BoabCmsBundle\EventListener;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Invetico\BoabCmsBundle\EventListener\BaseFileUploadListener;
use Invetico\BoabCmsBundle\Entity\ImageResizableInterface;
use Invetico\BoabCmsBundle\Entity\PhotoInterface;
use Invetico\BoabCmsBundle\Event\PhotoUploadEvent;

use Imagine\Image\Box;
use Imagine\Image\Point;

class PhotoUploadListener extends BaseFileUploadListener
{
	private $postSave;
	protected $files;

	public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $this->files = $request->files->all();
    }

	public function onPhotoCreate(PhotoUploadEvent $event)
	{	
		$entity = $event->getEntity();
		$photo = $event->getUploadedPhoto();

		if(!$entity instanceof PhotoInterface || !$photo instanceof UploadedFile){
			return false;
		}

		$oldThumbnail = $entity->getFileName();
		$generatedFileName = $this->generateFileName($photo);
		$entity->setFileName($generatedFileName);

		$uploadPath = $this->getUploadPhotoPath($entity->getUploadRoot()).'/'.$generatedFileName;
		$thumbnailUploadPath = $this->getUploadPhotoPath($entity->getThumbnailRoot()).'/'.$generatedFileName;
			
		$this->upload($photo, $uploadPath);
		if($entity instanceof ImageResizableInterface){
			$this->resizePhoto($photo, strtolower($thumbnailUploadPath), $entity->getDimension());
		}else{
			$this->upload($photo, $thumbnailUploadPath);
		}
		$uploadPath = $this->getUploadPhotoPath($entity->getUploadRoot()).'/'.$oldThumbnail;
		$thumbnailUploadPath = $this->getUploadPhotoPath($entity->getThumbnailRoot()).'/'.$oldThumbnail;
		$this->deleteFile($uploadPath);			
		$this->deleteFile($thumbnailUploadPath);	
	}	

	public function deletePhotos($entity)
	{
		$oldPhoto = $entity->getUploadRoot() . '/' . $entity->getFileName();
		$oldThumbnail = $entity->getThumbnailRoot() . '/' .$entity->getFileName();

		foreach(compact('oldThumbnail','oldPhoto') as $photo){
			if(is_file($photo) AND is_readable($photo)){
				$this->fileSystem->remove($photo);
			}
		}
	}

}