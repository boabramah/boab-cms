<?php

namespace Invetico\BoabCmsBundle\EventListener;


use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Arrow\Library\Uploader;
use Invetico\BoabCmsBundle\Event\EntityEvent;
use Invetico\BoabCmsBundle\Entity\DocumentInterface;
use Invetico\BoabCmsBundle\Entity\FileUploadInterface;
use Invetico\UserBundle\Event\ProfileThumbnailUploadEvent;
use Invetico\BoabCmsBundle\Event\ContentImageUploadEvent;


class FileUploadListener extends BaseFileUploadListener
{
	public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $this->files = $request->files->all();
    }


	public function onPreContentActivity(EntityEvent $event)
	{
		$entity = $event->getEntity();
		$token = $this->getToken($entity);
		if(!$entity instanceOf FileUploadInterface){
			return;
		}
		foreach ($this->files as $key => $file) {
			if(!$file instanceof UploadedFile){
				continue;
			}
			if(!$this->isFileAllowed($file)){
				throw new \InvalidArgumentException(sprintf('The file extension %s is not allowed. Allowed ones are [%s]',$file->getClientOriginalExtension(), implode(',', $this->allowedExt)));
			}
			$this->savedFile[$token][] = $this->saveFile($file, $entity);
		}
		$event->setEntity($entity);
		
	}


	public function onPostContentActivity(EntityEvent $event)
	{
		$entity = $event->getEntity();
		$token = $this->getToken($entity);
		if(!isset($this->savedFile[$token])){
			return;
		}
		$this->uploadFileToDestination($this->savedFile[$token], $entity);
		
		foreach($this->savedFile[$token] as $key => $value){
			$this->deleteOldFile($value['oldFile']);
		}
	}


	private function saveFile(UploadedFile $file, $entity)
	{
		$generatedFileName = $this->generateFileName($file);
		$ext = $file->getClientOriginalExtension();
		switch ($ext) {
			case 'mp3':
				$oldFile = $entity->getUploadRoot() . '/' . $entity->getAudio();
				$entity->setAudio($generatedFileName);
				break;
			case 'pdf':
				$oldFile = $entity->getUploadRoot() . '/' . $entity->getFile();
				$entity->setFile($generatedFileName);			
					
			default:
				$oldFile = $entity->getUploadRoot() . '/' . $entity->getThumbnail();
				$entity->setThumbnail($generatedFileName);
				break;
		}
		return compact('generatedFileName','file','oldFile');		
	}	


	private function uploadFileToDestination($files, $entity)
	{
		$uploadPath = $this->createUploadPath($entity->getUploadRoot());
		foreach ($files as $key => $value) {
			$filePath = $uploadPath.'/'.$value['generatedFileName'];
			try{
				$this->uploadPhoto($value['file'], $filePath);
			}catch( \InvalidArgumentException $e){
				die($e->getMessage());
			}
		}			
	}


	private function deleteOldFile($oldFile)
	{
		if(is_file($oldFile) AND is_readable($oldFile)){
			$this->fileSystem->remove($oldFile);
		}			
	}


	public function onContentImageUpload(ContentImageUploadEvent $event)
	{
		$entity = $event->getContent();
		$token = $this->getToken($entity);
		foreach($event->getFiles() as $key => $file) {
			if(!$file[0] instanceof UploadedFile){
				continue;
			}
			$this->savedFile[$token][] = $this->saveFile($file[0], $entity);
		}
		$this->uploadFileToDestination($this->savedFile[$token], $entity);
	}


}
