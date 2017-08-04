<?php

namespace Invetico\BoabCmsBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class PhotoUploadEvent extends Event
{
    private $photo;
    private $uploadedFile;

    public function __construct($photo, $uploadedFile)
    {
        $this->photo = $photo;
        $this->uploadedFile = $uploadedFile;
    }

    public function getEntity()
    {
        return $this->photo;
    }

    public function setEntity($photo)
    {
        return $this->photo = $photo;
    } 


    public function setUploadedPhoto($file)
    {
    	$this->uploaded = $file;
    }


    public function getUploadedPhoto()
    {
    	return $this->uploadedFile;
    }

}
