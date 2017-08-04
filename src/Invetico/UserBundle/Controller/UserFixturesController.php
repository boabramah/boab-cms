<?php

namespace Invetico\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Invetico\BoabCmsBundle\Controller\BaseController;
use Invetico\UserBundle\Repository\userRepositoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use RandomLib\Generator as RandomGenerator;

Class UserFixturesController extends BaseController
{	
	private $randomGenerator;
	private $encoder;

	function __Construct(RandomGenerator $randomGenerator, UserPasswordEncoderInterface $encoder)
	{
		$this->randomGenerator = $randomGenerator;
		$this->encoder = $encoder;
	}


    public function loadUsersAction(Request $request)
    {
        $file = __DIR__.'/../../../data/FakeName.csv';
        $fo = fopen($file, "r"); // CSV fiile
            //$openFile = fopen($exportFile, 'a');
        $i=1;

        //die('yesssss');
        
        while (($userData = fgetcsv($fo, "", ",")) !== FALSE){
            
            $user = $this->createUser($userData);
            $customerId = $this->randomGenerator->generateString(15, '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ');
            $user->setUserId($customerId);
            $user->setUsername($user->getUsername().'-'.$i);
            $user->setEmail(sprintf('%s_%s',$i, strtolower($user->getEmail())));
            $this->entityManager->persist($user);
            //var_dump($userData);
            //$this->customerService->dumpCustomer($emapData);
            if($i == 2000){
            	break;
            }
            $i++;
        }
        
        $this->entityManager->flush();
        die('Done')  ;
        /*
        if('POST' === $request->getMethod()){
            $files = $request->files->all();
            $file = $files['customerBatchFile'];
            try{
                $this->validateFileType($file);
                $fo = fopen($file->getPathname(), "r");
                $entityManager = $this->customerService->getManager();
                while (($emapData = fgetcsv($fo, "", ",")) !== FALSE){
                    $this->customerService->dumpCustomer($emapData);
                    //print_r($emapData);
                }
                $entityManager->flush();                
            }catch(\InvalidArgumentException $e){
                die($e->getMessage());
            }
        } 
        */ 
    } 


    private function createUser($data) 
    {
		$user = new \Invetico\UserBundle\Entity\Customer;
		$user->setUsername($data[15]);
		$user->setFirstname($data[4]);
		$user->setLastname($data[6]);
		$user->setContactNumber($data[18]);
		$user->setAddress($data[7]);
		$user->setEmail($data[14]);
		$user->setDob(new \DateTime($data[21]));
		$user->setOccupation($data[33]);
		$user->setCity($data[8]);
		$user->setCountry($data[13]);
		$user->setZipCode($data[11]);
		$user->setLatitude($data[43]);
		$user->setLongitude($data[44]);
		$user->setSalt(md5(uniqid()));
		$user->setRoles(['ROLE_USER']);
		$user->setDateRegistered(new \DateTime);
		$user->setAccountStatus('registered');
		$user->setIsLoggedIn(0);
        //$password = $this->encoder->encodePassword($user, 'xn3xnhell');
        $user->setPassword('$2y$12$7f92f4c32a89c0757434eusoeAqG4DlruENGRQLtXOUjkLj31oYjK');
        return $user;    	
    }


}
