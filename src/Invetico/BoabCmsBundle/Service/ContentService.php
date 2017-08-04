<?php

namespace Invetico\BoabCmsBundle\Service;

use Invetico\BoabCmsBundle\Service\BaseService;
use Invetico\UserBundle\Service\UserService;
use Invetico\BoabCmsBundle\Repository\ContentRepositoryInterface;
use Invetico\BoabCmsBundle\Helper\EventDispatcherHelper;
use Invetico\BoabCmsBundle\Entity\Content;
use Invetico\BoabCmsBundle\Entity\Menu;

class ContentService extends BaseService
{
	private $contentRepository;
	private $userService;

	use EventDispatcherHelper;

	public function __Construct(ContentRepositoryInterface $contentRepository, UserService $userService)
	{
		$this->contentRepository = $contentRepository;
		$this->userService = $userService;
	}

	public function createEntity()
	{
		$entityClassName = $this->contentRepository->getClassName();
		return new $entityClassName();
	}

	public function populateEntity($entity, $request)
	{
		$user = $this->userService->findById($this->securityContext->getIdentity()->getId());
		$entity->setUser($user);

		return $entity;
	}

	public function create($entity, $request=null)
	{
		$entity->setDateCreated(new \DateTime());
		$user = $this->userService->findById($this->securityContext->getIdentity()->getId());
		$entity->setUser($user);

		return $this->trigger($entity,'create');
	}

	public function update($entity, $request=null)
	{
		$this->toggleMenuVisibility($entity, $request);

        if ($entity->isPublished()) {
            $entity->setDatePublished($request->get('published_date'));
        }	
		
		return $this->trigger($entity,'update');
	}

	public function findById($id)
	{
		return $this->contentRepository->findContentById($id);
	}


	public function toggleMenuVisibility(Content $content, $request)
	{
		if(!$content->hasRoute()){
			return;
		}
		$route = $content->getMenu();
		if(Content::STATUS_DRAFT == $request->get('page_status')){
			$route->setVisibility(Menu::VISIBILITY_OFF);
			$content->setMenu($route);
		}
		$route->setVisibility(Menu::VISIBILITY_ON);
	}

}
