<?php

namespace Invetico\BoabCmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Invetico\BoabCmsBundle\Entity\Content;
use Invetico\BoabCmsBundle\Entity\FileUploadInterface;
use Invetico\BoabCmsBundle\Model\SeoInterface;
use Invetico\BoabCmsBundle\Model\SeoTrait;

/**
 * Audio
 * @ORM\Table(name="audio")
 * @ORM\Entity(repositoryClass="Invetico\BoabCmsBundle\Repository\ContentRepository")
 */
class Audio extends Content implements AudioInterface, FileUploadInterface, SeoInterface
{
	use SeoTrait;

    private $discr = 'audio';
    /**
     * @var string
     *
     * @ORM\Column(name="audio_file", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $audio;

	/**
     * @var string
     *
     * @ORM\Column(name="audio_author", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $author;    

    /**
     * Set audio
     *
     * @param string $audio
     * @return Sermon
     */
    public function setAudio($audio)
    {
        $this->audio = $audio;

        return $this;
    }

    /**
     * Get audio
     *
     * @return string 
     */
    public function getAudio()
    {
        return $this->audio;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Audio
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }    

	public function getContentTypeId()
	{
		return 'audio';
	}

    public function getContentTypeLabel()
    {
        return 'Audio';
    }

	public function getContentTypeDescription()
	{
		return 'Use for creating audio files';
	}	

    public function getRelativeRoot()
    {
        return 'media/audios';
    }    

   public function getUploadRoot()
    {
        return sprintf('%s/%s/%s',BASE_ROOT,$this->getRelativeRoot(),$this->getId());
    }    

    public function getThumbnailUrlPath()
    {
        return sprintf('%s/%s/%s',$this->getRelativeRoot(),$this->getId(),$this->getThumbnail());
    }    

    public function getAudioUrlPath()
    {
        return sprintf('%s/%s/%s',$this->getRelativeRoot(),$this->getId(),$this->getAudio());
    }        
	
}
