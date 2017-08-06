<?php

namespace Invetico\BoabCmsBundle\Util;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Flash
{
    private $flashBag;
    private $__notices = [];
    private $__warnings = [];
    private $__errors = [];
    private $__values = [];
    private $__successes = [];
    private $__infos = [];
    
    public function __construct(SessionInterface $session)
    {
        $this->flashBag = $session->getFlashBag();
    }

    public function initSessionFlashBag()
    {
        $flashData = $this->flashBag->all();
        foreach(['__successes', '__notices', '__warnings', '__errors', '__values','__infos'] as $key){

            if (!isset($flashData[$key])) {
                continue;
            }

            foreach ($flashData[$key] as $value) {
                if (!is_array($value)) {
                    array_push($this->$key, $value);
                    continue;
                }
                $this->$key = array_merge($this->$key, $value);
            }
        }
    }

    public function setNotice($message)
    {
        $this->flashBag->add('__notices', $message);
    }

    public function setInfo($info)
    {
        $this->flashBag->add('__infos', $info);
    }

    public function setSuccess($message)
    {
        $this->flashBag->add('__successes', $message);
    }

    public function setError($key, $message)
    {
        $this->flashBag->add('__errors', [$key => $message]);
    }

    public function setErrors(array $errors = array())
    {
        foreach ($errors as $key => $value) {
            $this->setError($key, $value);
        }
    }

    public function setValues(array $data = array())
    {
        foreach ($data as $key => $value) {
            $this->setValue($key, $value);
        }
    }

    public function setValue($field, $value)
    {
        $this->flashBag->add('__values', [$field => $value]);
    }

    public function getSuccesses()
    {
        if (empty($this->__successes)) {
            return '';
        }
        $errors = '<div id="flash-box" class="alert alert-success alert-dismissible flash-success" role="alert">';
        foreach ($this->__successes as $value) {
            $errors .= "<p>$value</p>";
        }
        $errors .= '</div>';

        return $errors;
    }

    public function getErrorNotice($key='')
    {
        if(empty($this->__errors)){
            return '';
        }
        $html = '<div id="flash-box" class="flash-error">';
        $text = ($key !='') ? $this->getError($key) : 'Please correct the following errors below';
        $html .= '<p>'.$text.'</p>';
        $html .='</div>';

        return $html;
    }


    public function getInfo()
    {
        if (empty($this->__infos)) {
            return '';
        }
        $html = '<div id="flash-box" class="flash-info">';
        foreach ($this->__infos as $value) {
            $html .= "<p>$value</p>";
        }
        $html .= '</div>';

        return $html;
    }


    public function getErrors()
    {
        if (empty($this->__errors)) {
            return '';
        }
        $errors = '<div id="flash-box" class="error"><h3>Error Encounted</h3>';
        $errors .= '<ul id="errors">';
        foreach ($this->__errors as $key => $value) {
            $errors .= "<li>$value</li>";
        }
        $errors .= '</ul></div>';

        return $errors;
    }

    public function getError($key, $format=false)
    {
        if (isset($this->__errors[$key])) {
            return '';
        }

        return (!$format) ? $this->__errors[$key] : $this->formatError($this->__errors[$key]);
    }

    public function getData($key)
    {
        return isset($this->__values[$key]) ? $this->__values[$key] : '';
    }

    public function getValue($key)
    {
        return isset($this->__values[$key]) ? $this->__values[$key] : '';
    }

    private function formatError($message)
    {
        return sprintf('<span class="error">%s</span>', $message);
    }
}
