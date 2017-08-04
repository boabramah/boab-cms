<?php

namespace Invetico\BankBundle\Repository;

use Doctrine\ORM\EntityManager;

class OfficerRepositoryFactory
{
	public function createService($entityManagerFactory)
	{
        $entityManager = $entityManagerFactory->getEntityManager();
        $metadataClass   = $entityManager->getClassMetadata('Invetico\UserBundle\Entity\User');
        $metadataClass->setCustomRepositoryClass('Invetico\BankBundle\Repository\OfficerRepository');

        return new OfficerRepository($entityManager, $metadataClass);		
	}
}