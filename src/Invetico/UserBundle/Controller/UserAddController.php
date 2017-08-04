<?php

namespace Invetico\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Invetico\BoabCmsBundle\Controller\InitializableControllerInterface;
use Invetico\UserBundle\Service\UserService;
use Invetico\UserBundle\Event\AccountRegisteredEvent;
use Invetico\UserBundle\Event\PasswordForgottenEvent;
use Invetico\UserBundle\Validation\ForgetPasswordFormValidation;
use Invetico\UserBundle\Validation\ResetPassword;
use Invetico\BoabCmsBundle\Helper\RandomStringGenerator;
use Invetico\BoabCmsBundle\Controller\AdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Invetico\UserBundle\Validation\Register as RegisterValidation;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */ 


Class UserAddController extends AdminController implements InitializableControllerInterface 
{
    private $userService;
    private $randomGenerator;
    private $encoder;

    use RandomStringGenerator;

    function __Construct(UserService $userService, $randomGenerator, $encoder) 
    {
        $this->userService = $userService;
        $this->randomGenerator = $randomGenerator;
        $this->encoder = $encoder;
    }


    public function initialize()
    {
        $this->template->setTheme('novi');
    }

}
