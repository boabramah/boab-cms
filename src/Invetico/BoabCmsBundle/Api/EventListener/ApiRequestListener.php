<?php

namespace Invetico\BoabCmsBundle\Api\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Invetico\BoabCmsBundle\Api\Exception\ApiException;

class ApiRequestListener
{
	private $requestFormats = ['json','xml'];

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if(!$request->attributes->has('_api')){
        	return;
        }
        //die($request->getContentType());

        $this->setRequestFormat($request);

        if($content = $request->getContent()){
            if('POST' === $request->getMethod() && 'form' === $request->getContentType() ){
                return;
            }
            $data = $this->decodeJsonData($content);
            $request->request->replace($data);
        }
    }

    private function decodeJsonData($content)
    {
        $data = @json_decode($content, true);
        if($data === null || json_last_error() !== JSON_ERROR_NONE) {
            throw new ApiException(400, "Invalid json data sent");
        } 
        return $data;
    }

    private function setRequestFormat($request)
    {
        $format = ($request->attributes->get('format'))?$request->attributes->get('format'):$request->getContentType();
        if(!in_array($format, $this->requestFormats)){
            throw new ApiException(400, sprintf("The supplied content type format is not supported", $format));
        }
        $request->attributes->set('format',$format);
    }

}
