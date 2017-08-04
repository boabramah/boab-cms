<?php

namespace Invetico\BoabCmsBundle\Validation;

use Symfony\Component\HttpFoundation\Request;
use Invetico\BoabCmsBundle\Validation\Exception\InvalidDataException;
use Invetico\BoabCmsBundle\Validation\FormValidationInterface;
use Invetico\BoabCmsBundle\Validation\DataContext;

class Validation implements ValidationInterface
{
	protected $fields = array();
	protected $errors = array();
	protected $data = array();
	protected $delegates = array();
	private $postData = [];

	public function __construct()
	{

	}

	public function validateRequest(Request $request, FormValidationInterface $form)
	{
		$this->postData = array_merge($request->request->all(), $request->files->all());
		$form->register($this);

	}


	public function add($field, $label, $callBack)
	{
		if(isset($this->fields[$field])){
			throw new \InvalidArgumentException(sprintf('This form field %s is already added', $field));
		}
		$this->fields[$field] = array($label,$callBack);
	}

	public function create($field, $label, $callBack)
	{
		$this->fields[$field] = array($label,$callBack);
		if(!isset($this->data[$field])){
			$this->data[$field] = '';
		}
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
		foreach ($this->fields as $key => $value) {	
			
			$data = $this->getPostData($key);
			$label = $value[0];
			$callBack = $value[1];

			try{
				$context = new DataContext($data,$label);
				call_user_func($callBack,$context);
				if(isset($this->delegates[$key])){
					call_user_func($this->delegates[$key], $data);
				}
			}catch(InvalidDataException $e){
				$this->setError($key,$e->getMessage());
			}
		}
		//die;
	}

	private function getPostData($key)
	{
		if(!isset($this->postData[$key])){
			return '';
		}
		return $this->postData[$key];
	}


	private function getCleanValue($value)
	{
		foreach ($value as $key => $val) {
			return array($key,$val[0],$val[1]);
		}
	}


	public function setError($key, $message)
	{
		$this->errors[$key] = $message;
	}


	public function isValid()
	{
		$this->run();
		return count($this->getErrors()) === 0;
	}


	public function getErrors()
	{
		return $this->errors;
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