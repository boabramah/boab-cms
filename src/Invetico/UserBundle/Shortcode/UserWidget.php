<?php

namespace Invetico\UserBundle\Shortcode;

use Invetico\BoabCmsBundle\Library\Shortcode;

class UserWidget extends Shortcode
{
    private $template;
    private $userRepository;

    /**
     * @var string
     */
    protected $name = 'userlisting';
 
    /**
     * @var array
     */
    protected $attributes = [];

    public function __construct($template, $userRepository)
    {
        $this->template = $template;
        $this->userRepository = $userRepository;
    }
 
    /**
     * @param string|null $content
     * @param array $atts
     * @return string
     */
    public function handle($content = null, array $atts=[])
    {
        $collection = $this->userRepository->findRegisteredMembers();
        $view = $this->template->load('UserBundle:Main:registered_members_widget');
        $view->collection = $collection;

        return $view->render();
    }
}