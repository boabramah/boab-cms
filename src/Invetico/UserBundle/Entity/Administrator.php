<?php

namespace Invetico\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Invetico\BoabCmsBundle\Entity\FileUploadInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * User
 *
 * @ORM\Table(name="user_administrator")
 * @ORM\Entity(repositoryClass="Invetico\UserBundle\Repository\UserRepository")
 */
class Administrator extends User implements AdminInterface
{
    const ROLE_DEFAULT = 'ROLE_SUPER_ADMIN';

    /**
     * @ORM\OneToMany(targetEntity="Invetico\BoabCmsBundle\Entity\Content", mappedBy="user")
     */
    private $contents;       
   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contents = new \Doctrine\Common\Collections\ArrayCollection();
        parent::__construct();
    }

    /**
     * Get role
     *
     * @return array
     */
    public function getRoles()
    {
        //var_dump(array_unique(array_merge($this->roles, [self::ROLE_DEFAULT])));
        //die();
        return array_unique(array_merge(parent::getRoles(), [self::ROLE_DEFAULT]));
    }    


    /**
     * Add contents
     *
     * @param \Invetico\BoabCmsBundle\Entity\Content $contents
     * @return User
     */
    public function addContent(\Invetico\BoabCmsBundle\Entity\Content $contents)
    {
        $this->contents[] = $contents;

        return $this;
    }

    /**
     * Remove contents
     *
     * @param \Invetico\BoabCmsBundle\Entity\Content $contents
     */
    public function removeContent(\Invetico\BoabCmsBundle\Entity\Content $contents)
    {
        $this->contents->removeElement($contents);
    }

    /**
     * Get contents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContents()
    {
        return $this->contents;
    }     
}
