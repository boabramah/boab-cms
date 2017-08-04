<?php

namespace Invetico\BoabCmsBundle\Api\Normalizer;

use Invetico\BoabCmsBundle\Api\Serializer\NormalizerInterface;
use Invetico\BoabCmsBundle\Entity\PhotoInterface;
use Symfony\Cmf\Component\Routing\ChainRouterInterface;
use Symfony\Cmf\Component\Routing\ChainRouter;

class PhotoNormalizer implements NormalizerInterface
{
	private $router;

	public function __construct()
	{
		//$this->router = $router;
	}

	public function normalize($content)
	{
		return array(
			'id' => $content->getId(),
			'caption' => $content->getCaption(),
			'contentType' => $content->getContentTypeLabel(),
			'author' => $content->getAuthoredBy(),
			'status' => status( $content->getStatus() ),
			'deleteUrl' => $this->router->generate('admin_content_delete',['id'=>$content->getId()]),
			'editUrl'=> $this->router->generate('admin_content_edit',['id'=>$content->getId()]),
		);
	}

	public function supports($object)
	{
		return $object instanceof PhotoInterface;
	}

}