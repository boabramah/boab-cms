<?php

namespace Invetico\BankBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Transaction
 *
 * @ORM\Entity (repositoryClass="Invetico\BankBundle\Repository\TransactionRepository")
 * @ORM\Table(name="account_transaction")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="transaction_type", type="string")
 * @ORM\DiscriminatorMap({"debit" = "DebitTransaction", "credit" = "CreditTransaction"})
 */

abstract class Transaction implements TransactionInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups({"detail", "list"})     
     */
    protected $id;   

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     * @Groups({"detail", "list"})     
     */
    protected $dateCreated;     

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     * @Groups({"detail", "list"})     
     */
    protected $description; 

    /**
     * @var string
     *
     * @ORM\Column(name="debit_amount", type="decimal", precision=0, scale=2, nullable=true, unique=false)
     */
    protected $debitAmount;

    /**
     * @var string
     *
     * @ORM\Column(name="credit_amount", type="decimal", precision=0, scale=2, nullable=true, unique=false)
     */
    protected $creditAmount;            

    /**
     * @var string
     *
     * @ORM\Column(name="balance", type="decimal", precision=0, scale=2, nullable=false, unique=false)
     * @Groups({"detail", "list"})     
     */
    protected $balance;    

    /**
     * @var \Invetico\BankBundle\Entity\Account
     *
     * @ORM\ManyToOne(targetEntity="Invetico\BankBundle\Entity\Account", inversedBy="transactions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="account_id", referencedColumnName="id", nullable=false)
     * })
     * @Groups({"detailx", "partial"})      
     */
    protected $account;     

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
     * @return Transaction
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
    public function getDateCreated($format = '')
    {
        return ($format !='') ? $this->dateCreated->format($format) : $this->dateCreated->format('d-m-Y');
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Transaction
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
     * Set debitAmount
     *
     * @param string $debitAmount
     *
     * @return Transaction
     */
    public function setDebitAmount($debitAmount)
    {        
        $this->debitAmount = $debitAmount;

        return $this;
    }

    /**
     * Get debitAmount
     *
     * @return string
     */
    public function getDebitAmount()
    {
        return $this->debitAmount;
    }

    /**
     * Set creditAmount
     *
     * @param string $creditAmount
     *
     * @return Transaction
     */
    public function setCreditAmount($creditAmount)
    {
        $this->creditAmount = $creditAmount;

        return $this;
    }

    /**
     * Get creditAmount
     *
     * @return string
     */
    public function getCreditAmount()
    {
        return $this->creditAmount;
    }

    /**
     * Set balance
     *
     * @param string $balance
     *
     * @return Transaction
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
     * Set account
     *
     * @param \Invetico\BankBundle\Entity\Account $account
     *
     * @return Transaction
     */
    public function setAccount(\Invetico\BankBundle\Entity\Account $account)
    {
        $this->account = $account;
        $this->account->addTransaction($this);
        $this->processAmount($this->getAmount());

        return $this;
    }

    /**
     * Get account
     *
     * @return \Invetico\BankBundle\Entity\Account
     */
    public function getAccount()
    {
        return $this->account;
    }
}
