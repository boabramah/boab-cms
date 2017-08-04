<?php

namespace Invetico\UserBundle\Api\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Invetico\UserBundle\Repository\UserRepositoryInterface;
use Invetico\ApiBundle\Exception\ApiException;

class ApiAuthenticationController
{
	private $userRepository;
	private $securityEncoder;
	private $jwtEncoderManager;

	public function __construct(UserRepositoryInterface $userRepository, $securityEncoder, $jwtEncoderManager)
	{
		$this->userRepository = $userRepository;
		$this->securityEncoder = $securityEncoder;
		$this->jwtEncoderManager = $jwtEncoderManager;
	}


	public function authenticateAction(Request $request)
	{
		//die(get_class($this->jwtEncoderManager));
		//echo 'Boabramah';
		//die;

		try{
			$userData = $this->getUserData($request);
		}catch(\Exception $e){
			die($e->getMessage());
		}

	    $user = $this->userRepository->findUserByUserName($userData['username']);

	    if(!$user) {
	        throw new ApiException(400,'Invalid username or password');
	    }

	    // password check
	    if(!$this->securityEncoder->isPasswordValid($user, $userData['password'])) {
			throw new ApiException(400,'Invalid username or password');
	    }
/*
        $token = $this->jwtEncoderManager->encode([
            'username' => $user->getUsername(),
            'exp' => time() + 3600 // 1 hour expiration
        ]);
*/
		$token = $this->jwtEncoderManager->create($user);
        $response = array(
            'token' => sprintf('Bearer %s', $token),
            'refreshToken' => null,
            'username'  => $user->getUsername(),
            'mail'      => $user->getEmail(),
        );        
        return $response;

	    // Return genereted tocken
	    return [
	    	'token'=>sprintf('Bearer %s', $token),
	    	'status'=>'success',
	    	'message' => 'Please use your generated token with care'
	    ];
	}

	private function getUserData(Request $request)	
	{
		$data = [
			'username'=>'',
			'password'=>''
		];
	    if(!$request->getContent()){
	    	$data['username'] = $request->get('username');
	    	$data['password'] = $request->get('password');	
	    	return $data;    	
	    }
	    $userData = json_decode($request->getContent()); 
        if(is_object($userData)){
	    	$data['username'] = $userData->username;
	    	$data['password'] = $userData->password;
	    	return $data;
        }
        return $data;
	}
}