<?php

namespace Invetico\BoabCmsBundle\Api\Security;

use Doctrine\ORM\EntityManager;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoder;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Invetico\UserBundle\Repository\UserRepositoryInterface;
use Invetico\BoabCmsBundle\Validation\Exception\ValidationException;

class AccessTokenAuthenticator extends AbstractGuardAuthenticator
{
    private $userRepository;
    private $jwtEncoder;
    private $securityEncoder;

    public function __construct(UserRepositoryInterface $userRepository, JWTEncoder $jwtEncoder, $securityEncoder)
    {
        $this->userRepository = $userRepository;
        $this->jwtEncoder = $jwtEncoder;
        $this->securityEncoder = $securityEncoder;        
    }

    public function getCredentials(Request $request)
    {
        $userData = json_decode($request->getContent());
        if(!is_object($userData)){
            return [
                'username' => '',
                'password' => ''
            ]; 
        }

        return [
            'username' => $userData->username,
            'password' => $userData->password
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $this->userRepository->findUserByUserName($credentials['username']);

    }


    public function checkCredentials($credentials, UserInterface $user)
    {
        if(!$this->securityEncoder->isPasswordValid($user, $credentials['password'])) {
            return false;
        } 
        return true;      
    }
    
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse(['message' => 'Invalid password or username'], 401);
    }
    
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $token = $this->jwtEncoder->encode([
            'username' => $token->getUsername(),
            'exp' => time() + 3600 // 1 hour expiration
        ]);

        $data = [
            'token'=>sprintf('Bearer %s', $token),
            'status'=>'success',
            'message' => 'Please use your generated token with care'
        ];
        return new JsonResponse($data);
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new JsonResponse('Auth header required', 401);
    }    
    
    public function supportsRememberMe()
    {
        return false;
    }

}
