<?php

namespace Invetico\BankBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Invetico\BoabCmsBundle\Controller\AdminController;
use Invetico\BoabCmsBundle\Controller\AccountPanelInterface;
use Invetico\BoabCmsBundle\Controller\InitializableControllerInterface;
use Invetico\BankBundle\Repository\AccountRepositoryInterface;
use Invetico\BankBundle\Entity\CreditTransaction;
use Invetico\BankBundle\Entity\DebitTransaction;


class ReportController extends AdminController implements InitializableControllerInterface
{
    private $accountRepository;
    
    public function __Construct(AccountRepositoryInterface $accountRepository) 
    {
        $this->accountRepository = $accountRepository;
    }


    public function initialize()
    {
        $this->template->setTheme('jayle');
    }


    public function indexAction(Request $request) 
    {
        $this->template->setTitle('Reports')
             ->bind('page_header',$this->template->getTitle());
        return $this->template; 
    }

}
