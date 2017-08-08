<?php

namespace Invetico\BoabCmsBundle\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use Invetico\BoabCmsBundle\Event\EntityEvent;

abstract class BaseService
{
    protected $request;
    protected $eventDispatcher;
    protected $entityManager;
    protected $securityContext;

    public function initialize()
    {

    }

    public function setEventDispatcher($eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function setRequest(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }

    public function create( $request, $callback=null)
    {
        $entity = $this->createEntity();
        $event = new EntityEvent($entity, $request);
        $this->eventDispatcher->dispatch('entity.pre_create',$event);

        $entity = $event->getEntity();

        $this->populateEntity( $entity, $request );

        if(is_callable($callback)){
            call_user_func_array($callback, [$entity, $request]);
        }
        $event->setEntity($entity);
        $this->eventDispatcher->dispatch('entity.post_create',$event);
        return $this->save($entity);
    }

    public function update( $entity, $callback=null )
    {
        $event = new EntityEvent($entity, $this->request);
        $this->eventDispatcher->dispatch('entity.pre_update',$event);

        $entity = $event->getEntity();
        if(is_callable($callback)){
            call_user_func_array($callback, array($entity, $this->request));
        }
        $this->populateEntity( $entity, $this->request );

        $entity = $this->save( $entity );
        $event->setEntity($entity);
        $this->eventDispatcher->dispatch('entity.post_update',$event);

        return $entity;
    }
    
    public function save( $entity )
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        return $entity;
    }

    public function delete($entity)
    {
        $event = new EntityEvent($entity, $this->request);
        $this->eventDispatcher->dispatch('entity.cleanup',$event);
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
        return;
    }

    abstract function createEntity();

    abstract function populateEntity( $entity, $request );

    abstract function findById( $id );


}
