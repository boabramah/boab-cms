<?php

namespace Invetico\BoabCmsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Invetico\BoabCmsBundle\Controller\AdminController;
use Invetico\BoabCmsBundle\Repository\PhotoRepositoryInterface;
use Invetico\BoabCmsBundle\Repository\ContentRepositoryInterface;
use Invetico\BoabCmsBundle\Validation\Exception\ValidationException;
use Invetico\BoabCmsBundle\Validation\Photo as PhotoValidation;
use Invetico\BoabCmsBundle\Entity\Photo;
use Invetico\BoabCmsBundle\Event\PhotoUploadEvent;
use Invetico\ApiBundle\Normalizer\PhotoUploadSuccessNormalizer;
use Invetico\ApiBundle\Normalizer\SuccessResponseNormalizer;

Class PhotoController extends AdminController
{
    private $photoRepository;
    private $contentRepository;
    
    function __Construct
    (
        PhotoRepositoryInterface $photoRepository, 
        ContentRepositoryInterface $contentRepository
    )
    {
        $this->photoRepository = $photoRepository;
        $this->contentRepository = $contentRepository;
        $this->eventDispatcher = $eventDispatcher;
    }


    public function uploadAction(Request $request, $contentId)
    {
        if(!'POST' === $request->getMethod()){
            throw new \InvalidArgumentException('Bad Request');
        }
            
        $this->validation->validateRequest($request, new PhotoValidation());
        if(!$this->validation->isValid()){
            throw new ValidationException(422, 'Correct the following errors', $this->validation->getErrors());
        }
        
        try{
            $content = $this->contentRepository->findContentById($contentId);
            
            $photo = new Photo();
            $photo->setContent($content);
            $photo->setCaption($request->get('photo_caption'));
            $photo->setDateCreated(new \DateTime('Now'));
            $userReference = $this->entityManager->getReference('Invetico\UserBundle\Entity\User', $this->getUserToken()->getId());
            $photo->setUser($userReference);
            
            $event = new PhotoUploadEvent($photo, $request->files->get('thumbnail'));
            $this->eventDispatcher->dispatch('photo.create',$event);
            
            $this->entityManager->persist($photo);
            $this->entityManager->flush();

        }catch(\Exception $e){
            throw new ValidationException(422,'Correct the following errors',['file'=>$e->getMessage()]);
        }

        $photo->setDeletePath($this->router->generate('photo_delete',['photoId'=>$photo->getId()],true));

        $param['code']=200;
        $param['status']='success';
        $param['message']='Photo uploaded successfully';
        $param['smallThumbnail'] = $this->generateAsset($photo->getSmallThumbnailPath());
        $param['largeThumbnail'] = $this->generateAsset($photo->getLargeThumbnailPath());
        $normalizer = new PhotoUploadSuccessNormalizer($param);
        $normalizer->setPhoto($photo);

        return $normalizer;
    }


    public function editAction(Request $request)
    {
        $photoId = $request->get('id');
        $caption = $request->get('photo_caption');
        $photo = $this->photoService->findById($photoId);
        $photo->setCaption($caption);
        $this->photoService->update($photo);

        $this->message->setStatus('success')
                          ->setSuccessContent(['photo'=>$photo,'text'=>'Photo updated successfully']);
            return $this->getJsonResponse($this->message);	
    }


    public function deleteAction(Request $request, $photoId)
    {
        $photo = $this->photoRepository->findById($photoId);
        if(!$photo){
            throw new HttpException(403, 'The Photo does not exist');
        }

        $photo[0]->cleanup();

        $this->entityManager->remove($photo[0]);
        $this->entityManager->flush();

        $normalizer = new SuccessResponseNormalizer([]);
        $normalizer->setMessage('Photo deleted successfully');
        return $normalizer;	
    }


}
