<?php

namespace Invetico\BoabCmsBundle\Model;

trait SeoTrait
{
    public function getMetaTitle()
    {
        return $this->getTitle();
    }


    public function getMetaDescription()
    {
        return $this->getSummary();
    } 

    public function getMetaAuthor()
    {
        return $this->getUser()->getFullName();
    }       

    public function getMetaThumbnail()
    {
        if(!$this->getThumbnail()){
            return false;
        }
        return $this->getThumbnailUrlPath();
    }   
}
