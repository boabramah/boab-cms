<?php

namespace Invetico\BoabCmsBundle\Api\Security;

use Doctrine\ORM\EntityManager;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\DefaultEncoder as JWTEncoder;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Invetico\UserBundle\Repository\UserRepositoryInterface;
use Invetico\BoabCmsBundle\Api\Exception\ApiException;

class JwtAuthenticator extends AbstractGuardAuthenticator
{
    private $userRepository;
    private $jwtEncoder;

    public function __construct(UserRepositoryInterface $userRepository, JWTEncoder $jwtEncoder)
    {
        $this->userRepository = $userRepository;
        $this->jwtEncoder = $jwtEncoder;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new JsonResponse('Auth header required', 401);
    }

    public function getCredentials(Request $request)
    {
        $extractor = new AuthorizationHeaderTokenExtractor('Bearer','Authorization');
       if(!$jsonWebToken = $extractor->extract($request)){
            throw new ApiException(403, 'Auth token not found.');            
        }       
        return ;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        
        try{
            $data = $this->jwtEncoder->decode($credentials);
        }catch(JWTDecodeFailureException $e){
            throw new ApiException(401, 'Invalid Request');
        }
        return $this->userRepository->findUserByUserName($data['username']);
    }


    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }
    
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        throw new ApiException(401, 'Authentication failed. Try login again');
    }
    
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return;
    }
    
    public function supportsRememberMe()
    {
        return false;
    }

}
