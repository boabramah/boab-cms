<?php

namespace Invetico\BoabCmsBundle\EventListener;


use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Invetico\BoabCmsBundle\Event\EntityEvent;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;

abstract class BaseFileUploadListener
{
	protected $request;
	protected $uploader;
	protected $fileSystem;
	protected $imagine;
	protected $files = [];
	protected $allowedExt = ['jpeg','jpg','png','gif','mp3','pdf','JPG'];
	protected $savedFile = [];
	protected $audioExt = ['mp3','mp4'];
	protected $imageExt = ['jpeg','jpg','png','gif'];

	public function __construct(Filesystem $fileSystem)
	{
		$this->fileSystem = $fileSystem;
		$this->imagine = new Imagine();
	}

	public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $this->files = $request->files->all();
    }	


	protected function getUploadPhotoPath($uploadPath)
	{
		if(!$this->fileSystem->exists($uploadPath)){
			$this->fileSystem->mkdir($uploadPath);
		}
		return $uploadPath;
	}


	protected function uploadPhoto(UploadedFile $file, $filePath)
	{
		$ext = $file->getClientOriginalExtension();
		if($this->isAudioFile($ext)){
			move_uploaded_file($file->getPathname(), $filePath);
			//$file->move($this->getUploadRootDir(), )
			return;
		}
		$openFile = $this->imagine->open($file->getPathname());
		$openFile->save($filePath);
	}

	protected function uploadDocument(UploadedFile $file, $destination)
	{
		move_uploaded_file($file->getPathname(), $destination);
	}


	protected function generateFileName(UploadedFile $file)
	{
		return sprintf('%s-%s-%s-%s.%s', date('Y'), date('m'), date('d'), uniqid(), strtolower($file->getClientOriginalExtension()));
	}

	protected function isFileAllowed(UploadedFile $file)
	{
		return in_array(strtolower($file->getClientOriginalExtension()), $this->allowedExt);
	}


	protected function isAudioFile($extension)
	{
		return in_array($extension, $this->audioExt);
	}
	

	protected function isImageFile($extension)
	{
		return in_array($extension, $this->imageExt);
	}


	protected function resizePhoto(UploadedFile $file, $filePath, Box $box)
	{
		$openFile = $this->imagine->open($file->getPathname());
		$openFile->resize($box)
				 ->save($filePath);
	}


	protected function createUploadPath($uploadPath)
	{
		return $this->getUploadPhotoPath($uploadPath);
	}

	protected function getToken($entity)
	{
		return md5(get_class($entity));
	}


	protected function getFileUploaded($name)
	{
		return isset($this->files[$name]) ? $this->files[$name] : null;
	}

	public function upload(UploadedFile $file, $destination )
    {
        $image = $this->imagine->open($file->getPathname());
        $image->save($destination);
    }

    // Check if the file's mime type is in the list of allowed mime types.
    protected function validateFileType(UploadedFile $file)
    {		
		if(!in_array($file->getClientOriginalExtension(), $this->getAllowedMimeTypes())){
			throw new \InvalidArgumentException(sprintf('The file extension %s is not allowed. Allowed ones are [%s]',$file->getClientOriginalExtension(), implode(',', $this->allowedExt)));
		}   	
    }

    protected function getAllowedMimeTypes()
    {
    	return $this->allowedExt;
    }

    protected function deleteFile($file)
    {
		if(is_file($file) AND is_readable($file)){
			$this->fileSystem->remove($file);
		}    	
    }

    /*
    $ext = $file->getClientOriginalExtension();
		if($this->isAudioFile($ext)){
			move_uploaded_file($file->getPathname(), $filePath);
			//$file->move($this->getUploadRootDir(), )
			return;
		}
		$openFile = $this->imagine->open($file->getPathname());
		$openFile->save($filePath);
	*/

}
