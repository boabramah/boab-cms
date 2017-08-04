<?php

namespace Invetico\BoabCmsBundle\Validation;

use Invetico\BoabCmsBundle\Validation\Exception\InvalidDataException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DataContext implements DataContextInterface
{
	private $data;
	private $label;

	public function __construct($data)
	{
		$this->data = $data;
	}


    public function setValue($value)
    {
        $this->data = $value;
        return $this;
    }


    public function getValue()
    {
        return $this->data;
    }


    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }


    public function getLabel()
    {
        return $this->label;
    }


	public function isRequire( $customMessage='' )
	{
		$message = sprintf('%s is require',$this->label);
        if(empty($this->data)){
			throw new InvalidDataException($customMessage ? $customMessage : $message);
		}
		return $this;
	}


	public function isAlpha()
	{
		if(!preg_match("/^([a-zA-Z])+$/", $this->data)){
            throw new InvalidDataException(sprintf('%s : Only alphabet allowed',$this->label));
		} 

		return $this; 
    }

    public function isNumber()
    {
        if(!preg_match("/^([0-9])+$/", $this->data)){
            throw new InvalidDataException(sprintf('%s : Only numbers allowed',$this->label));
        } 

        return $this; 
    } 


    public function notLessThan($criteria)
    {
        if(trim($this->data) < $criteria){
            throw new InvalidDataException(sprintf('%s %s is invalid ',$this->label, $this->data));
        } 
        return $this;         
    }

    public function isValidFullName()
    {
        if(!preg_match("/^([a-zA-Z ])+$/", trim($this->data))){
            throw new InvalidDataException(sprintf('Full name is not valid'));
        } 
        return $this; 
    }


    public function isEmail()
    {   
		if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i",$this->data)){
			throw new InvalidDataException(sprintf('%s is invalid',$this->label));
		}
		return $this;
    }


    public function minLength($criteria)
    {
    	if(strlen($this->data) < $criteria){
    		throw new InvalidDataException(sprintf('%s is invalid - Minimum of %d characters allowed',$this->label,$criteria));
    	}
		return $this;
    }


    public function maxLength($criteria)
    {
    	if(strlen($this->data) > $criteria){
    		throw new InvalidDataException(sprintf('%s is invalid - Maximum of %d characters allowed',$this->label,$criteria));
    	}
		return $this;
    }


    public function match($data, $customMessage ='')
    {
        $message = sprintf('%s is require',$this->label);
        if(false == (bool)($this->data === $data)){
            throw new InvalidDataException($customMessage ? $customMessage : $message);
        }
        return $this;
    }


    public function register($callable,array $arg=array())
    {
    	if(is_callable($callable)){
    		call_user_func_array($callable, $arg);
    	}else{
    		call_user_func($callable);
    	}
    	return $this;
    }


    public function isValidFile(array $fileTypes=[])
    {
        if(!$this->data instanceof UploadedFile){
            throw new InvalidDataException(sprintf('Can not call %s on an invalid datatype', __METHOD__));
        }
        $isValidExt = in_array(strtolower($this->data->getClientOriginalExtension()), $fileTypes);
        if(!$isValidExt){
            throw new InvalidDataException(sprintf('The file supplied is invalid, Valid ones - %s',implode(',',$fileTypes)));
        }
        return $this;
    }



}