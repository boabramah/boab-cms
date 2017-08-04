<?php

namespace Invetico\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Invetico\UserBundle\Entity\Administrator;

class LoadUserData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $randomGenerator = $this->container->get('random_generator');
        $userId = $randomGenerator->generateString(20, '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ');
        
        $encoder = $this->container->get('security.password_encoder');
        

        $user = new Administrator();
        $user->setUserId($userId);
        $user->setUsername('boabramah');
        $user->setSalt(md5(uniqid()));
        $password = $encoder->encodePassword($user, 'xn3xnhell');
        $user->setPassword($password);
        $user->setEmail('boabramah@yahoo.com');
        $user->setAddress('P.O Boax 1245 Madina');
        $user->setCity('Accra');
        $user->setCountry('Ghana');
        $user->setFirstname('Ernest');
        $user->setLastname('Boabramah');
        $user->setRoles(['ROLE_ADMIN','ROLE_SUPER_ADMIN']);

/*
        $user = new Administrator();
        $user->setUsername('pauladom');
        $user->setSalt(md5(uniqid()));

        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, 'pau@dom!25');
        $user->setPassword($password);
        $user->setEmail('admin@pauladomotchereafricatv.com');
        $user->setFirstname('Staff');
        $user->setLastname('Admin');
        $user->setRoles(['ROLE_ADMIN','ROLE_SUPER_ADMIN']);

*/

        $manager->persist($user);
        //$manager->persist($user1);
        $manager->flush();

        $this->addReference('admin-user', $user);
        //$this->addReference('admin-user', $user1);
    }
}