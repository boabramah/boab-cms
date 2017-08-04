<?php

namespace Invetico\MailerBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class ContactFormSubmitedEvent extends Event
{
    private $fullName;
    private $email;
    private $organisation;
    private $contactNumber;
    private $subject;
    private $message;
    private $attachment;

    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
        return $this;
    }

    public function getFullName()
    {
        return $this->fullName;
    }  

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    } 

    public function getEmail()
    {
        return $this->email;
    } 

    public function setOrganisation($organisation)
    {
        $this->organisation = $organisation;
        return $this;
    }

    public function getOrganisation()
    {
        return $this->organisation;
    }               

    public function setContactNumber($contactNumber)
    {
        $this->contactNumber = $contactNumber;
        return $this;
    }

    public function getContactNumber()
    {
        return $this->contactNumber;
    } 

    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }      

    public function setAttachment($file)
    {
        $this->attachment = $file;
    }

    public function getAttachment()
    {
        return $this->attachment;
    }

}
