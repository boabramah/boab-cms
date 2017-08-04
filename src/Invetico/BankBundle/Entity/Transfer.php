<?php

namespace Invetico\BankBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Account
 *
 * @ORM\Entity (repositoryClass="Invetico\BankBundle\Repository\TransferRepository")
 * @ORM\Table(name="transfer")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="transfer_type", type="string")
 */
abstract class Transfer implements TransferInterface
{
    const STATUS_PENDING = 'pending';

    const STATUS_COMPLETED = 'completed';

    const AUTH_TIMEOUT = '5';

    const AUTH_STATUS_FAILED = 'failed';
    
    const AUTH_STATUS_PASSED = 'passed';
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups({"detail"})     
     */
    protected $id;    

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     * @Groups({"detail"})     
     */
    protected $dateCreated;    

    /**
     * @var string
     *
     * @ORM\Column(name="reference_number", type="string", length=50, precision=0, scale=0, nullable=false, unique=true)
     * @Groups({"detail"})     
     */
    protected $referenceNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="authorization_code", type="string", length=50, precision=0, scale=0, nullable=true, unique=false)
     */
    protected $authorizationCode;

  /**
     * @var string
     *
     * @ORM\Column(name="auth_status", type="string", length=50, precision=0, scale=0, nullable=true, unique=false)
     */
    protected $authStatus;        

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="decimal", precision=0, scale=2, nullable=true, unique=false)
     * @Groups({"detail"})     
     */
    protected $amount; 

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=50, precision=0, scale=0, nullable=false, unique=false)
     * @Groups({"detail"})     
     */
    protected $status; 

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="process_date", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     * @Groups({"detail"})     
     */
    protected $processDate;            

    /**
     * @var Integer
     *
     * @ORM\Column(name="is_repeatable", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @Groups({"detail"})     
     */
    protected $isRepeatable; 


     /**
     * @var string
     *
     * @ORM\Column(name="transfer_frequency", type="string", length=100, precision=0, scale=0, nullable=true, unique=false)
     * @Groups({"detail"})     
     */
    protected $transferFrequency;    

     /**
     * @var string
     *
     * @ORM\Column(name="from_account", type="string", length=200, precision=0, scale=0, nullable=true, unique=false)
     * @Groups({"detail"})     
     */
    protected $fromAccount;

     /**
     * @var string
     *
     * @ORM\Column(name="to_account", type="string", length=200, precision=0, scale=0, nullable=true, unique=false)
     * @Groups({"detail"})     
     */
    protected $toAccount;   


    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=200, precision=0, scale=0, nullable=true, unique=false)
     * @Groups({"detail"})     
     */
    protected $description;     

    /**
     * @var \Invetico\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Invetico\UserBundle\Entity\User", inversedBy="transfers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * })    
     */
    protected $customer;               


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
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Transfer
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
    public function getDateCreated($format='')
    {
        return ($format !='') ? $this->dateCreated->format($format) : $this->dateCreated;
    }

    /**
     * Set referenceNumber
     *
     * @param string $referenceNumber
     *
     * @return Transfer
     */
    public function setReferenceNumber($referenceNumber)
    {
        $this->referenceNumber = $referenceNumber;

        return $this;
    }

    /**
     * Get referenceNumber
     *
     * @return string
     */
    public function getReferenceNumber()
    {
        return $this->referenceNumber;
    }

    /**
     * Set amount
     *
     * @param string $amount
     *
     * @return Transfer
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Transfer
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set processDate
     *
     * @param \DateTime $processDate
     *
     * @return Transfer
     */
    public function setProcessDate($processDate)
    {
        $this->processDate = $processDate;

        return $this;
    }

    /**
     * Get processDate
     *
     * @return \DateTime
     */
    public function getProcessDate()
    {
        return $this->processDate;
    }

    /**
     * Set isRepeatable
     *
     * @param integer $isRepeatable
     *
     * @return Transfer
     */
    public function setIsRepeatable($isRepeatable)
    {
        $this->isRepeatable = $isRepeatable;

        return $this;
    }

    /**
     * Get isRepeatable
     *
     * @return integer
     */
    public function getIsRepeatable()
    {
        return $this->isRepeatable;
    }

    /**
     * Set transferFrequency
     *
     * @param integer $transferFrequency
     *
     * @return Transfer
     */
    public function setTransferFrequency($transferFrequency)
    {
        $this->transferFrequency = $transferFrequency;

        return $this;
    }

    /**
     * Get transferFrequency
     *
     * @return integer
     */
    public function getTransferFrequency()
    {
        return $this->transferFrequency;
    }

    /**
     * Set fromAccount
     *
     * @param string $fromAccount
     *
     * @return Transfer
     */
    public function setFromAccount($fromAccount)
    {
        $this->fromAccount = $fromAccount;

        return $this;
    }

    /**
     * Get fromAccount
     *
     * @return string
     */
    public function getFromAccount()
    {
        return $this->fromAccount;
    }

    /**
     * Set toAccount
     *
     * @param string $toAccount
     *
     * @return Transfer
     */
    public function setToAccount($toAccount)
    {
        $this->toAccount = $toAccount;

        return $this;
    }

    /**
     * Get toAccount
     *
     * @return string
     */
    public function getToAccount()
    {
        return $this->toAccount;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Transfer
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }


    /**
     * Set authorizationCode
     *
     * @param string $authorizationCode
     *
     * @return Transfer
     */
    public function setAuthorizationCode($authorizationCode)
    {
        $this->authorizationCode = $authorizationCode;

        return $this;
    }

    /**
     * Get authorizationCode
     *
     * @return string
     */
    public function getAuthorizationCode()
    {
        return $this->authorizationCode;
    } 

    /**
     * Set authStatus
     *
     * @param string $authStatus
     *
     * @return Transfer
     */
    public function setAuthStatus($authStatus)
    {
        $this->authStatus = $authStatus;

        return $this;
    }

    /**
     * Get authStatus
     *
     * @return string
     */
    public function getAuthStatus()
    {
        return $this->authStatus;
    }   

   /**
     * Set customer
     *
     * @param \Invetico\UserBundle\Entity\User $customer
     *
     * @return Transfer
     */
    public function setCustomer(\Invetico\UserBundle\Entity\User $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \Invetico\UserBundle\Entity\User
     */
    public function getCustomer()
    {
        return $this->customer;
    }        


    public function isCompleted()
    {
        return self::STATUS_COMPLETED == $this->getStatus();
    }

    public function isPending()
    {
        return self::STATUS_PENDING == $this->getStatus();
    }


    public function isAuthorized()
    {
        return self::AUTH_STATUS_PASSED == $this->getAuthStatus();
    }

    public function isToday()
    {
       $date = $this->getProcessDate()->format('Y-m-d h:i:s');
       return date('Ymd', strtotime($date)) === date('Ymd');
    }

    public function authExpired()
    {
        //$dt1 = new \DateTime('1983-11-06');
        //$dt2 = new \DateTime('now', new \DateTimeZone('Africa/Accra'));
        $diff = $this->getDateCreated()->diff(new \DateTime('now'));        
        return $diff->i > self::AUTH_TIMEOUT;
    }    

 
}
