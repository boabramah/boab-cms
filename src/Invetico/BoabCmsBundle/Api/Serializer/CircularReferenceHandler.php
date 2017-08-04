<?php

namespace Invetico\BoabCmsBundle\Api\Serializer;

class CircularReferenceHandler
{
	public static function createCallback(){
		return function($object){
			return $object->getId();
		};
	}
}