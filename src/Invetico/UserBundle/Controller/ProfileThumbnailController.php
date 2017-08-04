<?php

namespace Invetico\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Invetico\UserBundle\Entity\User;
use Invetico\UserBundle\Service\UserService;
use Invetico\BoabCmsBundle\Controller\BaseController;
use Invetico\BoabCmsBundle\Controller\AccountPanelInterface;
use Invetico\BoabCmsBundle\Controller\InitializableControllerInterface;
use Invetico\UserBundle\Event\ProfileUpdatedEvent;
use Invetico\UserBundle\Event\ProfileThumbnailUploadEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Invetico\ApiBundle\Normalizer\SuccessResponseNormalizer;

class ProfileThumbnailController extends BaseController
{
	private $userService;

	public function __construct(userService $userService)
	{
		$this->userService = $userService;
	}


     public function profilePictureAction(Request $request)
    {
        $view = $this->template->load('UserBundle:Account:user_thumbnail');
        $view->action = $this->urlGenerator->generate('account_upload_thumbnail');
        $view->flash = $this->flash;
        $view->userToken = $this->securityContext->getIdentity();
        $this->template->setTitle('Change profile picture')
                     ->bind('page_header', $this->template->getTitle())
                     ->bind('content',$view);

        return $this->template;        
    }

    public function uploadThumbnailAction(Request $request, $userId)
    {
        $user = $this->userService->findById($userId);
        $oldThumbnail = $user->getThumbnail();      

        $profileThumbnailUploadEvent = new ProfileThumbnailUploadEvent($user);
        $profileThumbnailUploadEvent->setRequest($request);

        try{
            $this->eventDispatcher->dispatch('user.profile_thumbnail_uploaded',$profileThumbnailUploadEvent);
            $modifiedUser = $profileThumbnailUploadEvent->getUser();
        }catch(\Exception $e){
            throw new NotFoundHttpException($e->getMessage());
        }

        if ($oldThumbnail != $modifiedUser->getThumbnail()) {
            $this->userService->save($modifiedUser);
            $this->eventDispatcher->dispatch('user.profile_updated',new ProfileUpdatedEvent($modifiedUser));
        }

        $successResponse = new SuccessResponseNormalizer(array(
            'status'=>'success',
            'status_code'=>200,
            'status_message'=>'Thumbnail uploaded successfully'
        ));

        return $successResponse;
    }	
}