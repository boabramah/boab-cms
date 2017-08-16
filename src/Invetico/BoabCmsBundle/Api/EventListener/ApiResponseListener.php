<?php

namespace Invetico\BoabCmsBundle\Api\EventListener;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface as nic;
use Symfony\Component\Serializer\SerializerInterface;


class ApiResponseListener
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $request = $event->getRequest();
        $controllerResult = $event->getControllerResult();

        if(!$request->attributes->has('_api')){
            return;
        }

        if(is_array($controllerResult)){
            $response = new JsonResponse($controllerResult);
        }else{
            $response = new JsonResponse();
            $response->setContent($controllerResult);
        }
        
        $response->setStatusCode(200);
        $event->setResponse($response);

    }


    public function onKernelResponse(FilterResponseEvent $event)
    {
        $request = $event->getRequest();
        $result = $event->getResponse();
        if($result instanceof SelfAwareNormalizerInterface || $result instanceof NormalizerInterface ){
            $json = $this->serializer->serialize($result);
            $jsonResponse = new JsonResponse($json);
            $event->setResponse($jsonResponse);
            return;
        }
    }
} 