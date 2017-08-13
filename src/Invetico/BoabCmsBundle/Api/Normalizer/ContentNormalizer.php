<?php

namespace Invetico\BoabCmsBundle\Api\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Invetico\BoabCmsBundle\Entity\ContentInterface;
use Symfony\Cmf\Component\Routing\ChainRouterInterface;
use Symfony\Cmf\Component\Routing\ChainRouter;
use Invetico\BoabCmsBundle\Util\UtilCommon;

class ContentNormalizer implements NormalizerInterface
{
    private $router;
    private $contentTypeManager;

    use UtilCommon;

    public function __construct(ChainRouterInterface $router, $contentTypeManager)
    {
        $this->router = $router;
        $this->contentTypeManager = $contentTypeManager;
    }

    public function normalize($content, $format = null, array $context = [])
    {
        return [
            'id' => $content->getId(),
            'title' => $content->getTitle(),
            'contentType' => $this->getContentType($content),
            'author' => $content->getAuthoredBy(),
            'summary' => $content->getSummary(),
            'status' => $this->status($content->getStatus()),
            'deleteUrl' => $this->router->generate('admin_content_delete', ['contentId'=>$content->getId()], true),
            'editUrl' => $this->router->generate('admin_content_edit', ['id' => $content->getId()], true),
            'showUrl' => $this->router->generate('api_show_content', ['contentId' => $content->getId(),'_api'=>'rest'], true),
            'date_published' => $content->getDatePublished('d-m-Y h:i:sa'),
            'thumbnail' => sprintf("[asset path=%s]",$content->getDefaultThumbnail()),
        ];
    }

    public function supportsNormalization($object, $format = null)
    {
        return $object instanceof ContentInterface;
    }

    private function getContentType($content)
    {
        $typeManager = $this->contentTypeManager->getTypeByObject($content);
        
        return $typeManager->getTypeId();
    }

}
