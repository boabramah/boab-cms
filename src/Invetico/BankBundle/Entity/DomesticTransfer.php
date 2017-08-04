<?php

namespace Invetico\BankBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Table(name="domestic_transfer")
 * @ORM\Entity(repositoryClass="Invetico\BankBundle\Repository\TransferRepository")
 */
class DomesticTransfer extends Transfer implements DomesticTransferInterface
{
    const TRANSFER_TYPE = 'domestic';

    /**
     * @var string
     *
     * @ORM\Column(name="receiver_bank_name", type="string", length=50, precision=0, scale=0, nullable=false, unique=false)
     */
    private $receiverBankName;

    /**
     * @var string
     *
     * @ORM\Column(name="receiver_name", type="string", length=50, precision=0, scale=0, nullable=false, unique=false)
     */
    private $receiverName;

    /**
     * @var string
     *
     * @ORM\Column(name="receiver_account_number", type="string", length=50, precision=0, scale=0, nullable=false, unique=false)
     */
    private $receiverAccountNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="routing_number", type="string", length=50, precision=0, scale=0, nullable=false, unique=false)
     */
    private $routingNumber;                     

    /**
     * Set receiverBankName
     *
     * @param string $receiverBankName
     *
     * @return DomesticTransfer
     */
    public function setReceiverBankName($receiverBankName)
    {
        $this->receiverBankName = $receiverBankName;

        return $this;
    }

    /**
     * Get receiverBankName
     *
     * @return string
     */
    public function getReceiverBankName()
    {
        return $this->receiverBankName;
    }

    /**
     * Set receiverName
     *
     * @param string $receiverName
     *
     * @return DomesticTransfer
     */
    public function setReceiverName($receiverName)
    {
        $this->receiverName = $receiverName;

        return $this;
    }

    /**
     * Get receiverName
     *
     * @return string
     */
    public function getReceiverName()
    {
        return $this->receiverName;
    }

    /**
     * Set receiverAccountNumber
     *
     * @param string $receiverAccountNumber
     *
     * @return DomesticTransfer
     */
    public function setReceiverAccountNumber($receiverAccountNumber)
    {
        $this->receiverAccountNumber = $receiverAccountNumber;

        return $this;
    }

    /**
     * Get receiverAccountNumber
     *
     * @return string
     */
    public function getReceiverAccountNumber()
    {
        return $this->receiverAccountNumber;
    }

    /**
     * Set routingNumber
     *
     * @param string $routingNumber
     *
     * @return DomesticTransfer
     */
    public function setRoutingNumber($routingNumber)
    {
        $this->routingNumber = $routingNumber;

        return $this;
    }

    /**
     * Get routingNumber
     *
     * @return string
     */
    public function getRoutingNumber()
    {
        return $this->routingNumber;
    }

    /**
     * Set authorizationCode
     *
     * @param string $authorizationCode
     *
     * @return DomesticTransfer
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

    public function getTransferType()
    {
        return self::TRANSFER_TYPE;
    }    
}
