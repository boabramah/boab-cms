<?php


namespace Invetico\UserBundle\Security;

use Invetico\UserBundle\Service\UserService;
use Arrow\Validation\Validation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Invetico\UserBundle\Security\Exception\NotAuthenticatedException;
use Invetico\UserBundle\Security\Exception\AuthenticatedException;
use Invetico\UserBundle\Security\Exception\LogoutException;
use Invetico\UserBundle\Security\Exception\SessionExpiredException;
use Invetico\UserBundle\Security\Exception\AccessDeniedException;
use Invetico\UserBundle\Security\Session\UserToken;
use Invetico\UserBundle\Validation\Login;
use Invetico\UserBundle\Entity\User;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SecurityContext
{
    /**
     * Persistent storage handler
     *
     * @var Storage\StorageInterface
     */
    protected $validation = null;

    /**
     * Authentication adapter
     *
     * @var Adapter\AdapterInterface
     */
    protected $userService = null;


    protected $rules = array();



    protected $userToken = null;

    protected $authorization;

    protected $accessToken;

    /**
     * Constructor
     *
     * @param  Storage\StorageInterface $storage
     * @param  Adapter\AdapterInterface $adapter
     */
    public function __construct(AuthorizationCheckerInterface $authorization, TokenStorageInterface $accessToken)
    {
        $this->authorization = $authorization;
        $this->accessToken = $accessToken;
    }

    /**
     * Returns true if and only if an identity is available from storage
     *
     * @return bool
     */
    public function hasIdentity()
    {
        if(!$this->getIdentity()){
            return false;
        }
        return true;
    }

    /**
     * Returns the identity from storage or null if no identity is available
     *
     * @return mixed|null
     */
    public function getIdentity()
    {
        //die(get_class($this->accessToken));
        if(!$this->accessToken->getToken() instanceof UsernamePasswordToken){
            return null;
        }
        return $this->accessToken->getToken()->getUser();
    }


    public function logout()
    {
        if(!$this->getIdentity()){
           throw new LogoutException('Logout'); 
        }

        $user = $this->userService->findById($this->getIdentity()->getId());
        $user->setIsLoggedIn(0);
        $this->userService->save($user);

        $this->clearIdentity();

        throw new LogoutException('Logout'); 
    }



    public function isGranted(array $roles = [])
    {
        $userToken = $this->getIdentity();
        
        $user = $this->userService->findById($userToken->getId());
        $userRoles = $user->getRoles();

        if(empty($userRoles)){
            throw new AccessDeniedException('You are not authorize to access this page');
        }
        if(!$this->verifyRolesGranted($userRoles, $roles)){
            throw new AccessDeniedException('You are not authorize to access this page');
        }
        
        return $this;
    }


    private function verifyRolesGranted($userRoles, $roles)
    {
        foreach($roles as $role){
            if(in_array($role, $userRoles)){
                return true;
            }
        }
        return false;
    }


    public function refreshUserToken($user)
    {
        $this->clearIdentity();
        $this->setIdentity(new UserToken($user)); 
    }

   public function hasRole($role)
    {
        try {
            $this->validateRoleString($role);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
        return in_array($role, $this->getUserRoles()) ? true : false;
    }

    public function hasRoles(array $roles = [])
    {

    }

    private function validateRoleString($roles)
    {
        $roles = (array)$roles;
        foreach($roles as $role){
            if(strpos($role, 'ROLE_') === false){
                throw new \Exception(sprintf("MALFORMED ROLE STRING: The role string %s is invalid. Role should begin with the string ROLE_", $role));                
            }
        }
    }


    private function getUserRoles()
    {
        return $this->getIdentity()->getRoles();
    }    

}