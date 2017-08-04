<?php
namespace Invetico\BoabCmsBundle\Controller;

class AdminController extends BaseController
{
	public function save( $entity )
	{
		$this->entityManager->persist($entity);
		$this->entityManager->flush();
		return $entity;
	}


	public function delete($entity)
	{
		$this->entityManager->remove($entity);
		$this->entityManager->flush();
		return;
	}	
}
