<?php

namespace Invetico\BoabCmsBundle\ORM;

use Doctrine\ORM\EntityManager;

class RepositoryManagerFactory
{
	private $entityManagerFactory;

	public function __construct($entityManagerFactory)
	{
		$this->entityManagerFactory = $entityManagerFactory;
	}

	public function getRepository($entity)
	{
		return $this->doctrine->getManager()->getRepository($entity);
	}	

	public function createService($repositoryClass, $entityClass)
	{
    	//die(get_class($this->entityManagerFactory));
    	$entityManager = $this->entityManagerFactory->getEntityManager();
        $metadataClass   = $entityManager->getClassMetadata($entityClass);
        $metadataClass->setCustomRepositoryClass($repositoryClass);

        return new $repositoryClass($entityManager, $metadataClass);		
	}

}