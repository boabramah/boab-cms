<?php

namespace Invetico\BoabCmsBundle\EventListener;

use Symfony\Components\Filesystem\ExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Invetico\UserBundle\Event\AccountTerminatedEvent;
use Invetico\BoabCmsBundle\Event\ContentDeletedEvent;
use Invetico\BoabCmsBundle\Repository\ContentRepository;
use Invetico\BoabCmsBundle\Entity\ContentInterface;


class ContentRemovalListener
{
    private $contentRepository;
    private $filesystem;

    public function __construct(ContentRepository $contentRepository, Filesystem $filesystem)
    {
        $this->contentRepository = $contentRepository;
        $this->filesystem = $filesystem;
    }

    public function onAccountTerminated(AccountTerminatedEvent $event)
    {
        $user = $event->getUser();
        $userContents = $this->contentRepository->findContentByUserId($user->getId());

        $em = $this->contentRepository->getEntityManager();
        foreach ($userContents as $content) {
            if ($content->belongsTo($user->getId())) {
                $em->remove($content);
            }
        }
    }

    public function onContentDeleted(ContentDeletedEvent $event)
    {
        $content = $event->getContent();
        if(!$content instanceof ContentInterface){
            return;
        }
        $contentDir = $content->getUploadRoot().'/'.$content->getId();
        if ($this->filesystem->exists($contentDir)) {
            $this->filesystem->remove($contentDir);
        } 

        $content->removeAllPhotos();

        $thumbnail  = $content->getUploadRoot().'/'.$content->getThumbnail();     
        $this->filesystem->remove($thumbnail);
    }
   
}
