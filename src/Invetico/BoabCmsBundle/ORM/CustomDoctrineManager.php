<?php

namespace Invetico\BoabCmsBundle\ORM;

use Doctrine\ORM\EntityManager;

class CustomDoctrineManager
{
	private $doctrine;

	public function __construct($doctrine)
	{
		$this->doctrine = $doctrine;
	}

	public function getRepository($entity)
	{
		return $this->doctrine->getManager()->getRepository($entity);
	}	

	public function createService($repositoryClass, $entityClass)
	{
    	//die(get_class($this->entityManagerFactory));
    	$entityManager = $this->doctrine->getManager();
        $metadataClass   = $entityManager->getClassMetadata($entityClass);
        $metadataClass->setCustomRepositoryClass($repositoryClass);

        return new $repositoryClass($entityManager, $metadataClass);		
	}

}