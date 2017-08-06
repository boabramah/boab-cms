<?php

namespace Invetico\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Invetico\UserBundle\Service\UserService;
use Invetico\BoabCmsBundle\Controller\AdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Invetico\UserBundle\Repository\userRepositoryInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */	
Class UserRoleController extends AdminController 
{	
    private $userService;
    private $userRepository;
    private $serializer;

    function __Construct(UserService $userService, userRepositoryInterface $userRepository, SerializerInterface $serializer )
    {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
        $this->serializer = $serializer;
    }

    /**
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */	
    public function showUserRolesAction(Request $request, $username)
    {
        $user = $this->userRepository->findUserByUserName($username);
        if(!$user){
            return $this->pageNotFound('User does not exist');
        }
        $view = $this->template->load('UserBundle:Admin:roles.html.twig');
        $view->user = $user;

        return new Response($view->render());
    }

    /**
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function updateUserRolesAction(Request $request, $format)
    {
        $id  = (int) $request->get('user_id');
        $roles = $request->get('roles');

        $user = $this->userService->findById($id);
        $user->setRoles($roles);
        $this->userService->save($user);

        $response['status'] = 'success';
        $response['message'] = sprintf('Role for user <strong>%s</strong> updated successfully', $user->getFullName());

        return $this->serializer->serialize($response, $format);
    }
}
