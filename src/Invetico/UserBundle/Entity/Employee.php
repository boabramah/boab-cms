<?php

namespace Invetico\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Invetico\BoabCmsBundle\Entity\FileUploadInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Employee
 *
 * @ORM\Table(name="user_employee")
 * @ORM\Entity(repositoryClass="Invetico\UserBundle\Repository\UserRepository")
 */
class Employee extends User implements EmployeeInterface
{
    const ROLE_DEFAULT = 'ROLE_EMPLOYEE';

}
