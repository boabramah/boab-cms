<?php

namespace Invetico\UserBundle\Api\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Invetico\UserBundle\Repository\UserRepositoryInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\User\UserInterface;
use Invetico\ApiBundle\Exception\ApiException;
use Symfony\Component\Serializer\SerializerInterface;
use Invetico\MailerBundle\Repository\TokenRepository;
use Invetico\MailerBundle\Repository\TokenRepositoryInterface;

class ApiUserController
{
	private $userRepository;
	private $serializer;

	public function __construct(UserRepositoryInterface $repository, SerializerInterface $serializer)
	{
		$this->userRepository = $repository;
		$this->serializer = $serializer;
	}


	public function findAllAction(Request $request, $format)
	{

		$page = $request->get('page');		
		$collection = $this->userRepository->findUsers($page);

		return $this->serializer->serialize($collection, $format, ['groups'=>['list']]);
	}


	public function findUserAction(Request $request, $customerId, $format)
	{
		$user = $this->userRepository->findByUserId($customerId);
		if(!$user instanceof UserInterface){
			throw new ApiException(404, 'Customer not found');
		}
		$user->setIsDetail(true);
		return $this->serializer->serialize($user, $format, ['groups'=>['detail']]);
	}


	public function usersNearbyAction(Request $request, $username=null)
	{
		$lat = $request->get('lat');
		$lng = $request->get('lng');
		$radius = $request->get('radius');

		$collection = $this->userRepository->findUsersInRadius($lat,$lng,$radius);
		//$totalRecords = $this->userRepository->findTotalRecords();
		
		return $this->serializer->normalize($collection);
	}


	public function searchUsersAction(Request $request)
	{	
		$query = $request->get('query');
		$lat = $request->get('lat');
		$lng = $request->get('lng');
		$radius = $request->get('radius');
		$page = $request->get('page');		

		$collection = $this->userRepository->findUsersByCriteria($query, $lat, $lng, $radius, $page);
		//$totalRecords = $this->userRepository->findTotalRecords();
		
		return $this->serializer->normalize($collection);
	}

}

