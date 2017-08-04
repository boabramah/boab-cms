<?php

namespace Invetico\BoabCmsBundle\Repository;

use Doctrine\ORM\EntityManager;

class RepositoryFactory
{
	public static function createService($entityManagerFactory, $entity, $repositoryClass)
	{
        $entityManager = $entityManagerFactory->getEntityManager();
        $metadataClass   = $entityManager->getClassMetadata($entity);
        $metadataClass->setCustomRepositoryClass($repositoryClass);

        return new $repositoryClass($entityManager, $metadataClass);		
	}
}