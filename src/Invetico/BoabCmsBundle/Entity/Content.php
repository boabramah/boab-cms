<?php
namespace Invetico\BoabCmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Invetico\BoabCmsBundle\Entity\AbstractEntity;
use Invetico\BoabCmsBundle\Entity\DocumentInterface;


/**
* @ORM\Entity (repositoryClass="Invetico\BoabCmsBundle\Repository\ContentRepository")
 * @ORM\Table(name="contents")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="content_type", type="string")
 */

abstract class Content extends AbstractEntity implements ContentInterface
{
    const STATUS_DRAFT = 2;
    const STATUS_PUBLISHED = 1;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="summary", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    protected $summary;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    protected $body;

    /**
     * @var string
     *
     * @ORM\Column(name="thumbnail", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    protected $thumbnail;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", length=2, precision=0, scale=0, nullable=false, unique=false)
     */
    protected $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="is_featured", type="integer", length=2, precision=0, scale=0, nullable=false, unique=false)
     */
    protected $isFeatured;

    /**
     * @var integer
     *
     * @ORM\Column(name="promoted", type="integer", length=2, precision=0, scale=0, nullable=true, unique=false)
     */
    protected $promoted;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     */
    protected $dateCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_published", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     */
    protected $datePublished;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_keywords", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    protected $metaKeywords;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_description", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    protected $metaDescription;

    /**
     * @var integer
     *
     * @ORM\Column(name="layout_type", type="integer", length=2, precision=0, scale=0, nullable=true, unique=false)
     */
    protected $layoutType;

    /**
     * @var \Invetico\UserBundle\Entity\UserAdmin
     *
     * @ORM\ManyToOne(targetEntity="Invetico\UserBundle\Entity\Administrator", inversedBy="contents")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     * })
     */
    protected $user;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Invetico\BoabCmsBundle\Entity\Photo", mappedBy="content", cascade={"persist","remove"}, orphanRemoval=true)
     */
    protected $photos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add photo
     *
     * @param \Invetico\BoabCmsBundle\Entity\Photo $photo
     *
     * @return Content
     */
    public function addPhoto(\Invetico\BoabCmsBundle\Entity\Photo $photo)
    {
        $this->photos[] = $photo;

        return $this;
    }

    /**
     * Remove photo
     *
     * @param \Invetico\BoabCmsBundle\Entity\Photo $photo
     */
    public function removePhoto(\Invetico\BoabCmsBundle\Entity\Photo $photo)
    {
        $this->photos->removeElement($photo);
    }

    /**
     * Get photos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhotos()
    {
        return $this->photos;
    }

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
     * Set title
     *
     * @param  string $title
     * @return Page
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slug
     *
     * @param  string $slug
     * @return Page
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set summary
     *
     * @param  string $summary
     * @return Page
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set body
     *
     * @param  string  $body
     * @return Content
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set thumbnail
     *
     * @param  string $thumbnail
     * @return Page
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return string
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * Set user
     *
     * @param  \Invetico\UserBundle\Entity\User $user
     * @return Page
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
     * Set status
     *
     * @param  integer $status
     * @return Page
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set isFeatured
     *
     * @param  integer $isFeatured
     * @return Content
     */
    public function setIsFeatured($isFeatured)
    {
        $this->isFeatured = !empty($isFeatured) ? 1 : 0;

        return $this;
    }

    /**
     * Get isFeatured
     *
     * @return integer
     */
    public function getIsFeatured()
    {
        return $this->isFeatured;
    }

    public function isFeatured()
    {
        return (bool) $this->getIsFeatured();
    }
    /**
     * Set promoted
     *
     * @param  integer $promoted
     * @return Content
     */
    public function setPromoted($promoted='')
    {
        $this->promoted = !empty($promoted) ? 1 : 0;

        return $this;
    }

    /**
     * Get promoted
     *
     * @return integer
     */
    public function getPromoted()
    {
        return $this->promoted;
    }

    public function isPromoted()
    {
        return (bool) $this->getPromoted();
    }

    /**
     * Set dateCreated
     *
     * @param  \DateTime $dateCreated
     * @return Page
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
     * Set datePublished
     *
     * @param  \DateTime $datePublished
     * @return Page
     */
    public function setDatePublished($datePublished=null)
    {
        $this->datePublished = new \DateTime('now');
        if ($datePublished) {
            $date = array_reverse(explode('-',$datePublished));
            $this->datePublished = new \DateTime(implode('-',$date));
        }

        return $this;
    }

    /**
     * Get datePublished
     *
     * @return \DateTime
     */
    public function getDatePublished($format='')
    {
        if (!$this->datePublished) {
            return;
        }

        $format = $format ? $format : $this->dateformat;

        return $this->datePublished->format($format);
    }

    /**
     * Set metaKeyWords
     *
     * @param string $metaKeyWords
     *
     * @return Content
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    /**
     * Get metaKeyWords
     *
     * @return string
     */
    public function getMetaKeyWords()
    {
        return $this->metaKeywords;
    }

    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     *
     * @return Content
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * Get metaDescription
     *
     * @return string
     */
    public function getMetaDescription()
    {     
        return $this->metaDescription;
    }

    /**
     * Set layoutType
     *
     * @param integer $layoutType
     * @return Content
     */
    public function setLayoutType($layoutType)
    {
        $this->layoutType = $layoutType;

        return $this;
    }

    /**
     * Get layoutType
     *
     * @return integer 
     */
    public function getLayoutType()
    {
        return $this->layoutType;
    }

    /**
    * Remove all user Roles
    */
    public function removeAllPhotos()
    {
       $this->photos->clear();
    }    
    

    public function getAuthoredBy()
    {
        return $this->getUser()->getFullName();
    }

    public function belongsTo($userId)
    {
        return (bool) ($this->getUser()->getId() === $userId);
    }

    public function hasRoute()
    {
        if (!$this->getMenu()) {
            return false;
        }

        return true;
    }


    public function isPublished()
    {
        return (self::STATUS_PUBLISHED == $this->getStatus());
    } 

    public function getDefaultThumbnail()
    {
        $defaultThumbnail = 'images/default-profile-thumbnail.jpg';
        return $this->getThumbnail() ? $this->getThumbnailUrlPath() : $defaultThumbnail;
    } 

    public function hasThumbnail()
    {
        $file = $this->getUploadRoot() . '/' . $this->getThumbnail();
        if (!$this->getThumbnail() or !file_exists($file)) {
            return false;
        }

        return true;
    } 

    public function getRelativeRoot()
    {
        return 'media/images';
    }

    public function getUploadRoot()
    {
        return BASE_ROOT . $this->getRelativeRoot();
    }

    public function getThumbnailUrlPath()
    {
        return $this->getRelativeRoot() .'/'. $this->getThumbnail();
    } 

    public function getMonthYear()    
    {
        return $this->datePublished->format('d F Y');        
    }            
}
