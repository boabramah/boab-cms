<?php

namespace Invetico\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Invetico\BoabCmsBundle\Entity\FileUploadInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * User
 *
 * @ORM\Table(name="user_customers")
 * @ORM\Entity(repositoryClass="Invetico\UserBundle\Repository\UserRepository")
 */
class Customer extends User implements CustomerInterface
{ 
    /**
     * @var string
     * @Groups({"detail"})
     * @ORM\Column(name="occupation", type="string", length=200, precision=0, scale=0, nullable=true, unique=false)
     */
    private $occupation; 

    /**
     * @var string
     *
     * @ORM\Column(name="zip_code", type="integer", length=100, precision=0, scale=0, nullable=true, unique=false)
     */
    private $zipCode; 

    /**
     * @var string
     *
     * @Groups({"detail"})
     * @ORM\Column(name="latitude", type="string", length=100, precision=0, scale=0, nullable=true, unique=false)
     */
    private $latitude; 

    /**
     * @var string
     * @Groups({"detail"})
     * @ORM\Column(name="longitude", type="string", length=100, precision=0, scale=0, nullable=true, unique=false)
     */
    private $longitude;             

    /**
     * Set occupation
     *
     * @param string $occupation
     *
     * @return Employee
     */
    public function setOccupation($occupation)
    {
        $this->occupation = $occupation;

        return $this;
    }

    /**
     * Get occupation
     *
     * @return string
     */
    public function getOccupation()
    {
        return $this->occupation;
    }

    /**
     * Set zipCode
     *
     * @param integer $zipCode
     *
     * @return Employee
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return integer
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return Employee
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return Employee
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
  

}
