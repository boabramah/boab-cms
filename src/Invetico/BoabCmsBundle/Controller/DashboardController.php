<?php

namespace Invetico\BoabCmsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Invetico\BoabCmsBundle\Controller\AdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Invetico\BoabCmsBundle\Repository\ContentRepositoryInterface;
use Invetico\BoabCmsBundle\Model\ContentTypeManagerInterface;
use Invetico\BoabCmsBundle\Event\DashboardEvent;

/**
 * @Security("has_role('ROLE_USER')")
 */
Class DashboardController extends AdminController
{
    private $contentTypeManager;
    private $contentRepository;

    public function __Construct
    ( 
        ContentTypeManagerInterface $contentTypeManager,
        ContentRepositoryInterface $contentRepository
    ) 
    {
        $this->contentTypeManager = $contentTypeManager;
        $this->contentRepository = $contentRepository;
    }

    public function initialize()
    {
        $this->template->setTheme('novi');
    }    


    public function indexAction(Request $request)
    {

/*        $results = $this->contentRepository->findTotalContentByYear();
        $types = $this->getContentTypeCount($results);
*/
       // $this->eventDispatcher->dispatch('app.dashboard', new DashboardEvent());
        if (!$request->get('splash')) {
            $this->flash->setInfo('You have to update your profile information');

            return $this->redirect($this->router->generate('account_home', ['splash'=>2]));
        }
        
        //$view->contentTypes = $types;
        $this->template->setTitle('Dashboard')
             ->bind('page_header', 'Dashboard')
             //->bind('content', $view)
             ->setBlock('contentArea', 'dashboard.html.twig');

        return $this->template;
    }


    private function getContentTypeCount($results)
    {
        $content = array();
        foreach ($results as $key => $value) {
            $content[$value['type']] = $value;
        }

        $contentTypes = $this->contentTypeManager->getContentTypes();
        foreach ($contentTypes as $key => $type) {
            $entity = $type->getEntity();
            $id = strtolower($entity->getContentTypeId());
            if(isset($content[$id])){
                $content[$id]['route_name'] = '';
                $content[$id]['label'] = $entity->getContentTypeLabel();
                continue;
            }
            $content[$id] = array();
            $content[$id]['route_name'] = '';
            $content[$id]['count'] = 0;
            $content[$id]['label'] = $entity->getContentTypeLabel();
        }
        return $content;       

    }

}
