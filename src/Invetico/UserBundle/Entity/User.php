<?php

namespace Invetico\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Invetico\BoabCmsBundle\Entity\AbstractEntity;
use Invetico\BoabCmsBundle\Entity\FileUploadInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="user_type", type="string")
 * @ORM\Entity(repositoryClass="Invetico\UserBundle\Repository\UserRepository")
 */
abstract class User implements UserInterface, FileUploadInterface, \Serializable
{
    const ROLE_DEFAULT = 'ROLE_USER';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @Groups({"detail", "list"})
     * @ORM\Column(name="user_id", type="string", length=20, precision=0, scale=0, nullable=false, unique=true)
     */
    protected $userId;

    /**
     * @var string
     * @Groups({"detail", "list"})
     * @ORM\Column(name="username", type="string", length=100, precision=0, scale=0, nullable=false, unique=true)
     */
    protected $username;

    /**
     * @var string
     * @Groups({"detail", "list"})
     * @ORM\Column(name="firstname", type="string", length=100, precision=0, scale=0, nullable=true, unique=false)
     */
    protected $firstname;

    /**
     * @var string
     * @Groups({"detail", "list"})     
     * @ORM\Column(name="lastname", type="string", length=100, precision=0, scale=0, nullable=true, unique=false)
     */
    protected $lastname;

    /**
     * @var integer
     * @Groups({"detail"})     
     * @ORM\Column(name="dob", type="date", nullable=true)
     */
    protected $dob;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date_registered", type="date", nullable=true)
     */
    protected $dateRegistered;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date_deactivated", type="date", nullable=true)
     */
    protected $dateDeactivated;

    /**
     * @var integer
     * @Groups({"detail"})
     * @ORM\Column(name="contact_number", type="string", length=30, precision=0, scale=0, nullable=true, unique=false)
     */
    protected $contactNumber; 

    /**
     * @var string
     * @Groups({"detail"})
     * @ORM\Column(name="address", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    protected $address;

    /**
     * @var string
     * @Groups({"detail"})
     * @ORM\Column(name="city", type="string", length=100, precision=0, scale=0, nullable=true, unique=false)
     */
    protected $city;     

    /**
     * @var string
     * @Groups({"detail"})
     * @ORM\Column(name="country", type="string", length=100, precision=0, scale=0, nullable=true, unique=false)
     */
    protected $country;    

    /**
     * @var string
     * @Groups({"detail"})
     * @ORM\Column(name="postal_code", type="string", length=100, precision=0, scale=0, nullable=true, unique=false)
     */
    protected $postalCode; 

    /**
     * @var string
     * @Groups({"detail", "list"})
     * @ORM\Column(name="email", type="string", length=100, precision=0, scale=0, nullable=false, unique=true)
     */
    protected $email;       


    /**
     * @var string
     * @Groups({"detail"})
     * @ORM\Column(type="array", name="roles")
     */
    protected $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=100, precision=0, scale=0, nullable=false, unique=false)
     */
    protected $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=100, precision=0, scale=0, nullable=false, unique=false)
     */
    protected $salt; 

    /**
     * @var integer
     *
     * @ORM\Column(name="is_logged_in", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    protected $isLoggedIn;


    /**
     * @var string
     *
     * @ORM\Column(name="account_status", type="string", length=100, precision=0, scale=0, nullable=true, unique=false)
     */

    protected $accountStatus;    

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_last_active", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     */
    protected $lastActiveDate;

    /**
     * @var string
     *
     * @ORM\Column(name="thumbnail", type="string", length=100, precision=0, scale=0, nullable=true, unique=true)
     */
    protected $thumbnail; 


    /**
     * @ORM\OneToMany(targetEntity="Invetico\BankBundle\Entity\Account", mappedBy="customer", cascade={"persist","remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"dateCreated" = "DESC"})     
     */
    protected $accounts;  

    /**
     * @ORM\OneToMany(targetEntity="Invetico\BankBundle\Entity\Transfer", mappedBy="customer", cascade={"persist","remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"dateCreated" = "DESC"})     
     */
    protected $transfers;

    /**
     * Constructor
     */
    public function __construct()
    {

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
     * Set userId
     *
     * @param string $userId
     *
     * @return User
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }    

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }
    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }


    /**
     * Set contactNumber
     *
     * @param string $contactNumber
     *
     * @return UserAdmin
     */
    public function setContactNumber($contactNumber)
    {
        $this->contactNumber = $contactNumber;

        return $this;
    }

    /**
     * Get contactNumber
     *
     * @return string
     */
    public function getContactNumber()
    {
        return $this->contactNumber;
    } 


    public function addRole($role)
    {
        $role = strtoupper($role);
        if (!in_array($role, $this->getRoles(), true)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return User
     */
    public function setRoles(array $roles)
    {
        $this->roles = array();

        foreach ($roles as $role) {
            $this->addRole($role);
        }

        return $this;
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
        return array_unique(array_merge($this->roles, [self::ROLE_DEFAULT]));
    }


    public function hasRole($role)
    {
        return in_array(strtoupper($role), $this->getRoles(), true);
    }


    /**
     * Set thumbnail
     *
     * @param string $thumbnail
     * @return User
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
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        //$this->password = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt='')
    {
        $this->salt = ($salt !='')? $salt : uniqid(mt_rand(), true);
        return $this;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }


    /**
     * Set isLoggedIn
     *
     * @param integer $isLoggedIn
     * @return User
     */
    public function setIsLoggedIn($isLoggedIn)
    {
        $this->isLoggedIn = $isLoggedIn;

        return $this;
    }

    /**
     * Get isLoggedIn
     *
     * @return integer 
     */
    public function getIsLoggedIn()
    {
        return $this->isLoggedIn;
    }


    /**
     * Set dateRegistered
     *
     * @param \DateTime $dateRegistered
     * @return User
     */
    public function setDateRegistered($dateRegistered)
    {
        $this->dateRegistered = $dateRegistered;

        return $this;
    }

    /**
     * Get dateRegistered
     *
     * @return \DateTime 
     */
    public function getDateRegistered()
    {
        return $this->dateRegistered;
    }

    /**
     * Set accountStatus
     *
     * @param string $accountStatus
     * @return User
     */
    public function setAccountStatus($accountStatus)
    {
        $this->accountStatus = $accountStatus;

        return $this;
    }

    /**
     * Get accountStatus
     *
     * @return string 
     */
    public function getAccountStatus()
    {
        return $this->accountStatus;
    }    

    /**
     * Set lastActiveDate
     *
     * @param \DateTime $lastActiveDate
     * @return User
     */
    public function setLastActiveDate($lastActiveDate)
    {
        $this->lastActiveDate = $lastActiveDate;

        return $this;
    }

    /**
     * Get lastActiveDate
     *
     * @return \DateTime 
     */
    public function getLastActiveDate()
    {
        return $this->lastActiveDate;
    }

    /**
     * Set dateDeactivated
     *
     * @param \DateTime $dateDeactivated
     * @return User
     */
    public function setDateDeactivated($dateDeactivated)
    {
        $this->dateDeactivated = $dateDeactivated;

        return $this;
    }

    /**
     * Get dateDeactivated
     *
     * @return \DateTime 
     */
    public function getDateDeactivated()
    {
        return $this->dateDeactivated;
    }


    /**
     * Set dob
     *
     * @param \DateTime $dob
     *
     * @return User
     */
    public function setDob($dob)
    {
        $this->dob = $dob;

        return $this;
    }

    /**
     * Get dob
     *
     * @return \DateTime
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }


    /**
     * Set city
     *
     * @param string $city
     *
     * @return Employee
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Employee
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }    

    /**
     * Set postalCode
     *
     * @param string $postalCode
     *
     * @return User
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Add account
     *
     * @param \Invetico\BankBundle\Entity\Account $account
     *
     * @return Customer
     */
    public function addAccount(\Invetico\BankBundle\Entity\Account $account)
    {
        $this->accounts[] = $account;

        return $this;
    }

    /**
     * Remove account
     *
     * @param \Invetico\BankBundle\Entity\Account $account
     */
    public function removeAccount(\Invetico\BankBundle\Entity\Account $account)
    {
        $this->accounts->removeElement($account);
    }

    /**
     * Get accounts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAccounts()
    {
        return $this->accounts;
    }

    /**
     * Add transfer
     *
     * @param \Invetico\BankBundle\Entity\Transfer $transfer
     *
     * @return User
     */
    public function addTransfer(\Invetico\BankBundle\Entity\Transfer $transfer)
    {
        $this->transfers[] = $transfer;

        return $this;
    }

    /**
     * Remove transfer
     *
     * @param \Invetico\BankBundle\Entity\Transfer $transfer
     */
    public function removeTransfer(\Invetico\BankBundle\Entity\Transfer $transfer)
    {
        $this->transfers->removeElement($transfer);
    }

    /**
     * Get transfers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTransfers()
    {
        return $this->transfers;
    }        


    public function eraseCredentials()
    {

    }

    
    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }    

    public function getUploadRoot()
    {
        return 'images/users';
    }


    public function getThumbnailPath()
    {
        return sprintf('%s/%s',$this->getUploadRoot(),$this->getThumbnail());
    }


    public function getDefaultThumbnailPath()
    {
        if(!$this->getThumbnail()){
            return 'images/default-profile-thumbnail.jpg';
        }
        return sprintf('%s/%s', $this->getUploadRoot(),$this->getThumbnail());
    }

    /**
     * @Groups({"detail", "list"})
     */
    public function getAvatar()
    {
        return '[asset path=images/default-profile-thumbnail.jpg]';
    }


    public function getFullName()
    {
        return $this->getFirstname() .' '. $this->getLastname();
    }


    public function cleanup()
    {
        $oldThumbnail = $this->getUploadRoot() . '/' . $this->getThumbnail();
        //exit($oldThumbnail);
        if (is_file($oldThumbnail) and is_readable($oldThumbnail)) {
            unlink($oldThumbnail);
        }
    } 

    private $flag = false;

    public function setIsDetail($flag)
    {
        $this->flag = $flag;
    }

    public function isDetail()
    {
        return $this->flag;
    }       

}
