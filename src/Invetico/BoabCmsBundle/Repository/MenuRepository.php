<?php
namespace Invetico\BoabCmsBundle\Repository;

use Invetico\BoabCmsBundle\Repository\BaseRepository;
use Bundle\PageBundle\Entity\Page;

class MenuRepository extends BaseRepository implements MenuRepositoryInterface
{
    protected $visibleRouteCollections;
    protected $allRouteCollection;
    protected $allRoute = [];

    public function getAllMenus()
    {
        if(!empty($this->allRoute)){
            return $this->allRoute;
        }
        $query = $this->getMenuQuery()
                       ->orderBy('m.position','ASC')
                       ->getQuery();
        $query->useResultCache(true, 2000, __METHOD__ . serialize($query->getParameters()))
              ->useQueryCache(true);
        $this->allRoute =  $query->getResult();  

        return $this->allRoute;
    }


    public function getMenuItemChildren($parentId)
    {
    	$qb = $this->getMenuQuery()
    	    ->where('m.parentId = :parentId')
            ->andWhere('m.visibility = 1')
            ->setParameter('parentId', $parentId)
            ->orderBy('m.position', 'ASC');
        return $qb->getQuery()->getResult();
    }

    public function findAllRouteChildrenById($parentId)
    {

        $qb = $this->getMenuQuery()
            ->where('m.parentId = :parentId')
            ->setParameter('parentId', $parentId)
            ->orderBy('m.position', 'ASC');
        return $qb->getQuery()->getResult();        
    }

    
    public function getFindAllMenu()
    {
        return $this->findAllVisibleMenus();
    }


    public function findAllVisibleMenus()
    {
        $routes = [];
        foreach($this->getAllMenus() as $item){
            if($item->isVisible()){
                $routes[] = $item;
            }
        }
        return $routes;

/*
        $qb = $this->getMenuQuery()
           ->where('m.visibility = :visible')
           ->setParameter('visible',1)
            ->orderBy('m.position', 'ASC');
        return $qb->getQuery()->getResult();
        */
    }


    private function getMenuQuery()
    {
    	$qb = $this->_em->createQueryBuilder();
    	$qb->select('m')
    	   ->from('Invetico\BoabCmsBundle\Entity\Menu', 'm');
    	return $qb;
    }

    public function getQuery()
    {
        $dql = "SELECT m, c 
                FROM Invetico\BoabCmsBundle\Entity\Menu m 
                LEFT JOIN m.children c 
                WHERE m.parent IS NULL";
        $query = $this->_em->createQuery($dql);
        return $query->getResult();
    }
}
