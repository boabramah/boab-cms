<?php

namespace Invetico\UserBundle\Security;


class AccessControlCollection
{	
	protected $rules = array();


	public function __construct(){}


    public function match($path)
    {
        $callback = null;
        foreach($this->rules as $rule){
            $route = $rule['path'];
            if(preg_match('#'.$route.'#',$path)){
                $callback = $rule['callback'];
                break;
            }
        }
       return $callback;
    }


    public function add($path,$callback)
    {
        $this->rules[] = compact('path','callback');
    }
}