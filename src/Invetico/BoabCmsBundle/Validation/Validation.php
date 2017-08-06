<?php

namespace Invetico\BoabCmsBundle\Validation;

use Symfony\Component\HttpFoundation\Request;
use Invetico\BoabCmsBundle\Validation\Exception\InvalidDataException;
use Invetico\BoabCmsBundle\Validation\FormValidationInterface;
use Invetico\BoabCmsBundle\Validation\DataContext;

class Validation implements ValidationInterface
{
    protected $fields = [];
    protected $errors = [];
    protected $data = [];
    protected $delegates = [];
    protected $postData = [];

    public function __construct()
    {
        
    }

    public function validateRequest(Request $request, FormValidationInterface $form)
    {
        $this->postData = array_merge($request->request->all(), $request->files->all());
        $form->register($this);
    }

    public function add($field,$callBack)
    {
        if(isset($this->fields[$field])){
            throw new \InvalidArgumentException(sprintf('This form field %s is already added', $field));
        }
        if(!isset($this->postData[$field])){
            throw new \InvalidArgumentException(sprintf('The field %s does not exists on the post form.',$field));
        }		
        $this->fields[$field] = $callBack;
    }

    public function set(array $fields = array(), $callBack)
    {
        foreach($fields as $field => $label){
            $this->add($field, $label, $callBack);
        }
    }

    public function get($key)
    {
        if(!isset($this->data[$key])){
            return false;
        }
        return $this->data[$key];
    }

    public function delegate($field, $callBack)
    {
        if(isset($this->delegates[$field])){
            throw new \InvalidArgumentException(sprintf('The field %s has already been added to the validation.',$field));
        }
        $this->delegates[$field] = $callBack;
    }

    private function run()
    {
        foreach ($this->fields as $key => $callBack) {			
            $data = $this->getPostData($key);
            try{
                $context = new DataContext($data);
                call_user_func($callBack,$context);
                if(isset($this->delegates[$key])){
                    call_user_func($this->delegates[$key], $data);
                }
            }catch(InvalidDataException $e){
                //die($e->getMessage());
                $this->setError($key,$e->getMessage());
            }
        }
    }

    private function getPostData($key)
    {
        if(!isset($this->postData[$key])){
            return '';
        }
        return $this->postData[$key];
    }

    public function setError($key, $message)
    {
        $this->errors[$key] = $message;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function isValid()
    {
        $this->run();
        return empty($this->getErrors());
    }

    public function areRequire(array $fields = array())
    {
        foreach($fields as $field => $label){
            $this->add($field, $label,function(DataContextInterface $e){
                $e->isRequire();
            });
        }
    }
}