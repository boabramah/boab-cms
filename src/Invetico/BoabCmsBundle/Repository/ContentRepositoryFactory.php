<?php

namespace Invetico\BoabCmsBundle\Repository;

use Doctrine\ORM\EntityManager;

class ContentRepositoryFactory
{
	private $entityManagerFactory;

	public function __construct($entityManagerFactory)
	{
		$this->entityManagerFactory = $entityManagerFactory;
	}

	public function createService($repositoryClass)
	{
    	$entityManager = $this->entityManagerFactory->getEntityManager();
        $metadataClass   = $entityManager->getClassMetadata('Invetico\BoabCmsBundle\Entity\Content');
        $metadataClass->setCustomRepositoryClass($repositoryClass);

        return new $repositoryClass($entityManager, $metadataClass);		
	}
}