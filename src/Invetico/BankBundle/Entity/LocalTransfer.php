<?php

namespace Invetico\BankBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Table(name="local_transfer")
 * @ORM\Entity(repositoryClass="Invetico\BankBundle\Repository\TransferRepository")
 */
class LocalTransfer extends Transfer implements LocalTransferInterface
{
    const TRANSFER_TYPE = 'local';
    
    public function getTransferType()
    {
    	return self::TRANSFER_TYPE;
    }
}
