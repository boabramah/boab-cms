<?php

namespace Invetico\MailerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MailToken
 *
 * @ORM\Table(name="mail_token")
 * @ORM\Entity(repositoryClass="Invetico\MailerBundle\Repository\TokenRepository")
 */
class MailToken
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
     * @ORM\Column(name="token", type="string", length=100, precision=0, scale=0, nullable=true, unique=false)
     */
    private $token;     

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     */
    private $dateCreated;


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
     * Set token
     *
     * @param string $token
     *
     * @return MailToken
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return MailToken
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
        return $this->dateCreated;
    }
}
