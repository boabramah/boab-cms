<?php

namespace Invetico\BoabCmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Invetico\BoabCmsBundle\Entity\Content;
use Invetico\BoabCmsBundle\Entity\FileUploadInterface;

/**
 * Serminar
 * @ORM\Table(name="video")
 * @ORM\Entity(repositoryClass="Invetico\BoabCmsBundle\Repository\ContentRepository")
 */
class Video extends Content implements VideoInterface,FileUploadInterface
{
    private $discr = 'video';

    /**
     * @var string
     *
     * @ORM\Column(name="youtube_video_id", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $youtubeVideoId;

    /**
     * Set youtubeVideoId
     *
     * @param  string $youtubeVideoId
     * @return Video
     */
    public function setYoutubeVideoId($youtubeVideoId)
    {
        $this->youtubeVideoId = $youtubeVideoId;

        return $this;
    }

    /**
     * Get youtubeVideoId
     *
     * @return string
     */
    public function getYoutubeVideoId()
    {
        return $this->youtubeVideoId;
    }

    public function getVideoUrl()
    {
        return sprintf('http://www.youtube.com/watch?v=%s', $this->getYoutubeVideoId());
    }
}
