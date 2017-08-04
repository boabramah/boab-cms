<?php

namespace Invetico\BoabCmsBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;
use Symfony\Cmf\Component\Routing\RouteProviderInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\RouterInterface;
use Invetico\BoabCmsBundle\View\Template;

class BreadcrumbListener
{
	private $template;
	private $router;
	private $routeProvider;
	private $request;

	public function __construct(Template $template,RouterInterface $router, RouteProviderInterface $routeProvider)
	{
		$this->template = $template;
		$this->router = $router;
		$this->routeProvider = $routeProvider;
	}

	public function onKernelRequest(GetResponseEvent $event)
	{
		//echo $event->getRequestType();
		//echo HttpKernelInterface::MASTER_REQUEST;
		//die;

		if(!$event->isMasterRequest()) {
			//die('subrequest');
			return;
		}		
		$request = $request = $event->getRequest();
		$url = $request->getPathInfo();		
	
		$delimiterCount = substr_count($url,"/");
		$uriParts = explode('/',$url);
		$matchedUrls = [];
	
		$urlString = '/';
		for ($i=1; $i < count($uriParts); $i++) { 
			$urlString .= ($i==1)  ? $uriParts[$i] : sprintf('/%s', $uriParts[$i]);
			try{
				$urlMatched = $this->router->match($urlString);
				//substr_count($urlMatched['_route',"_profiler")
				if(substr_count($urlMatched['_route'],"_profiler")){
					break;
				}
				$urlMatched['_path'] = $this->router->generate($urlMatched['_route']);
				array_push($matchedUrls, $urlMatched);
			}catch(ResourceNotFoundException $e){
				//die($e->getMessage());
			}catch(MissingMandatoryParametersException $e){
				//die($e->getMessage());
			}			
		}
		
		//var_dump($matchedUrls);
		//die;

	}

}
