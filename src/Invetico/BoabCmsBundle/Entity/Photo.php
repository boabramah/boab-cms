<?php

namespace Invetico\BoabCmsBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Invetico\BoabCmsBundle\Entity\ImageResizableInterface;
use Imagine\Image\Box;
/**
 * User
 *
 * @ORM\Table(name="photos")
 * @ORM\Entity(repositoryClass="Invetico\BoabCmsBundle\Repository\PhotoRepository")
 */
class Photo implements ImageResizableInterface, PhotoInterface
{
   /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="caption", type="text", precision=0, scale=0, nullable=false, unique=false)
     */
    private $caption;

    /**
     * @var string
     *
     * @ORM\Column(name="file_name", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $fileName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreated", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $dateCreated;

    /**
     * @var \Invetico\AlbumBundle\Entity\Album
     *
     * @ORM\ManyToOne(targetEntity="Invetico\BoabCmsBundle\Entity\Content", inversedBy="photos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="content_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $content;


    private $thumbnailScr;

    private $photoUrlPath;
 
    private $deleteUrlPath;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set caption
     *
     * @param string $caption
     * @return Photo
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * Get caption
     *
     * @return string 
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     * @return Photo
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string 
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Photo
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->dateCreated->format($this->dateformat);
    }


    /**
     * Set user
     *
     * @param \Invetico\UserBundle\Entity\User $user
     * @return Photo
     */
    public function setUser(\Invetico\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Invetico\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set content
     *
     * @param \Invetico\BoabCmsBundle\Entity\Content $content
     *
     * @return Photo
     */
    public function setContent(\Invetico\BoabCmsBundle\Entity\Content $content = null)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return \Invetico\BoabCmsBundle\Entity\Content
     */
    public function getContent()
    {
        return $this->content;
    }    


    private function getPhotoRelativePath()
    {
         return $this->getContent()->getRelativeRoot().'/'.$this->getContent()->getId();
    }


    public function getUploadRoot()
    {
        return  $this->getContent()->getUploadRoot().'/'.$this->getContent()->getId();
    }


    public function getUrlPath()
    {
        return $this->getPhotoRelativePath(). '/' .$this->getFileName();
    }

    public function getThumbnailRoot()
    {
        return $this->getUploadRoot(). '/thumbs';
    }


    public function getSmallThumbnailPath()
    {
        return $this->getPhotoRelativePath(). '/thumbs/'.$this->getFileName();
    }

    public function getLargeThumbnailPath()
    {
        return $this->getPhotoRelativePath(). '/' .$this->getFileName();        
    }

    public function setDeletePath($path)
    {
        $this->deleteUrlPath = $path;
    }

    public function getDeletePath()
    {
        return $this->deleteUrlPath;
    }

    public function getDimension()
    {
        return new Box(200, 160);
    }  

    public function cleanup()
    {
        $photos = [
            $this->getUploadRoot() . '/' . $this->getFileName(),
            $this->getThumbnailRoot() . '/'.$this->getFileName()
        ];
        foreach($photos as $key => $photo){
            if(is_file($photo) AND is_readable($photo)){
                unlink($photo);
            }
        }
    }

}
