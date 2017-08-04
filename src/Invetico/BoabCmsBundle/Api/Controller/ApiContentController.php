<?php

namespace Invetico\BoabCmsBundle\Api\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Invetico\BoabCmsBundle\Repository\ContentRepositoryInterface;
use Invetico\BoabCmsBundle\Api\Normalizer\ContentNormalizer;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Serializer\SerializerInterface;

class ApiContentController
{
	private $contentRepository;
	private $serializer;

	public function __construct(ContentRepositoryInterface $repository, SerializerInterface $serializer)
	{
		$this->contentRepository = $repository;
		$this->serializer = $serializer;
	}


	public function findContentAction(Request $request, $format)
	{
		$page = $request->get('page');
		
		$collection = $this->contentRepository->getAllContents($page);
		$totalRecords = $this->contentRepository->findContentCount();
		$data = [
			'data'=> $collection,
			'draw' => 1,
			'recordsFiltered'=>count($collection),
			'recordsTotal'=>$totalRecords,
		];
		return $this->serializer->normalize($data, $format);
	}


	public function showContentAction(Request $request)  	
	{
		$contentId = $request->get('contentId');
		$content = $this->contentRepository->findContentById($contentId);
		if(!$content){
			throw new HttpException(404, 'The resource does not exist');
		}
		return $content;
	}

}