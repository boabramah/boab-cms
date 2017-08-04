<?php

namespace Invetico\BoabCmsBundle\Api\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Invetico\BoabCmsBundle\Entity\ContentInterface;
use Symfony\Cmf\Component\Routing\ChainRouterInterface;
use Symfony\Cmf\Component\Routing\ChainRouter;

class ContentNormalizer implements NormalizerInterface
{
	private $router;

	public function __construct(ChainRouterInterface $router)
	{
		$this->router = $router;
	}

	public function normalize($content, $format = null, array $context = [])
	{
		return [
			'id' => $content->getId(),
			'title' => $content->getTitle(),
			'contentType' => $content->getContentTypeLabel(),
			'author' => $content->getAuthoredBy(),
			'summary'=> $content->getSummary(),
			'status' => status( $content->getStatus() ),
			'deleteUrl' => $this->router->generate('admin_content_delete',['contentId'=>$content->getId()], true),
			'editUrl'=> $this->router->generate('admin_content_edit',['id'=>$content->getId()], true),
			'showUrl'=> $this->router->generate('api_show_content',['contentId'=>$content->getId(),'_api'=>'rest'], true),
			'date_published' => $content->getDatePublished('d-m-Y h:i:sa'),
			'thumbnail' => $this->getBasePath().$content->getDefaultThumbnail(),
		];
	}

	public function getBasePath()
	{
		return $this->router->generate('site_root',[],true);
	}

	public function supportsNormalization($object, $format = null)
	{
		return $object instanceof ContentInterface;
	}

}