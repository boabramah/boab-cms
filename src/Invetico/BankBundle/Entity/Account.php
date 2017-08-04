<?php

namespace Invetico\BankBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Invetico\BankBundle\Entity\Transaction;
use Invetico\BankBundle\Entity\DebitTransactionInterface;
use Invetico\BankBundle\Entity\CreditTransactionInterface;
use Invetico\BankBundle\Exception\InsufficientFundException;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * Account
 *
 * @ORM\Entity (repositoryClass="Invetico\BankBundle\Repository\AccountRepository")
 * @ORM\Table(name="accounts")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="fuel_type", type="string")
 */
abstract class Account implements AccountInterface
{
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
     * @Groups({"detail", "list","partial"})
     * @ORM\Column(name="account_number", type="string", length=50, precision=0, scale=0, nullable=false, unique=true)
     */
    protected $accountNumber;

    /**
     * @var string
     * @Groups({"detail", "list", "partial"})
     * @ORM\Column(name="account_name", type="string", length=200, precision=0, scale=0, nullable=true, unique=false)
     */
    protected $accountName;     

    /**
     * @var string
     *
     * @ORM\Column(name="account_status", type="string", length=50, precision=0, scale=0, nullable=false, unique=false)
     */
    protected $accountStatus;        

    /**
     * @var \Invetico\UserBundle\Entity\User
     * @Groups({"detail"})
     * @ORM\ManyToOne(targetEntity="Invetico\UserBundle\Entity\User", inversedBy="accounts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customer_id", referencedColumnName="id", nullable=false)
     * })
     */
    protected $customer; 

    /**
     * @ORM\OneToMany(targetEntity="Invetico\BankBundle\Entity\Transaction", mappedBy="account", cascade={"persist","remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"dateCreated" = "DESC"})     
     */
    protected $transactions;              

    /**
     * @var string
     * @Groups({"detail", "list"})
     * @ORM\Column(name="balance", type="decimal", precision=0, scale=2, nullable=true, unique=false)
     */
    protected $balance; 

    /**
     * @var \DateTime
     * @Groups({"detail", "list"})
     * @ORM\Column(name="date_created", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     */
    protected $dateCreated;    

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->transactions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Account
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
        return $this->dateCreated->format('d-m-Y');        
        //return $this->dateCreated;
    }

    /**
     * Set accountNumber
     *
     * @param string $accountNumber
     *
     * @return Account
     */
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    /**
     * Get accountNumber
     *
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * Set accountName
     *
     * @param string $accountName
     *
     * @return Account
     */
    public function setAccountName($accountName)
    {
        $this->accountName = $accountName;

        return $this;
    }



    /**
     * Get accountName
     *
     * @return string
     */
    public function getAccountName()
    {
        if(!$this->accountName){
            return $this->getDefaultAccountName();
        }
        return $this->accountName;
    }        

    /**
     * Set accountStatus
     *
     * @param string $accountStatus
     *
     * @return Account
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
     * Set balance
     *
     * @param string $balance
     *
     * @return Account
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * Get balance
     *
     * @return string
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * Add transaction
     *
     * @param \Invetico\BankBundle\Entity\Transaction $transaction
     *
     * @return Account
     */
    public function addTransaction(Transaction $transaction)
    {
        $this->transactions[] = $transaction;
    }

    /**
     * Remove transaction
     *
     * @param \Invetico\BankBundle\Entity\Transaction $transaction
     */
    public function removeTransaction(\Invetico\BankBundle\Entity\Transaction $transaction)
    {
        $this->transactions->removeElement($transaction);
    }

    /**
     * Get transactions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTransactions()
    {
        return $this->transactions;
    }


    /**
     * Set customer
     *
     * @param \Invetico\UserBundle\Entity\User $customer
     *
     * @return Account
     */
    public function setCustomer(\Invetico\UserBundle\Entity\User $customer)
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

    /**
     * @Groups({"detail", "list"})
     */
    public function getStatus()
    {
        return $this->getAccountStatus();
    }    

    /**
     * @Groups({"detail", "list"})
     */
    public function getAccountType()
    {
        return $this->getAccountTypeId();
    }


    public function deposit($amount)
    {
        $this->balance = $this->balance + $amount;
    }

    public function withdraw($amount)
    {
        if($amount > $this->getBalance()){
            throw new InsufficientFundException(sprintf("Insufficient fund to withdraw [currency amount=%s] from account. Account Balance is [currency amount=%s]",$amount, $this->getBalance()));
        }        
        $this->balance = $this->balance - $amount;
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
