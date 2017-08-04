<?php
namespace Invetico\BoabCmsBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class BaseRepository extends EntityRepository
{
	protected $rowsPerPage;

    const MAX_RESULTS = 20;

    const CURRENT_PAGE = 1;

    public function paginate($query, $page=null, $rowsPerPage = null)
    {
    	$rowsPerPage = ($rowsPerPage != null) ? $rowsPerPage : self::MAX_RESULTS;
        $page = ($page != null) ? $page : self::CURRENT_PAGE;
		$offset = ($page - 1) * $rowsPerPage;

    	$query->setFirstResult($offset)
              ->setMaxResults($rowsPerPage);
    	return new Paginator($query, $fetchJoinCollection = true);
    }


    public function createQuery($dql)
    {
    	return $this->_em->createQuery($dql);
    }


    public function getEntityManager()
    {
        return $this->_em;
    }


    protected function getContentQuery($contentType = '')
    {
        $qb = $this->_em->createQueryBuilder();
        $class = ($contentType !='') ? $contentType : 'Invetico\BoabCmsBundle\Entity\Content';
        $qb->select('c','m','u')
           ->from($class, 'c')
           ->leftJoin('c.menu','m')
           ->leftJoin('c.user', 'u');

        return $qb;
    }    


    protected function addParams($qb, $params)
    {
        if (empty($params)) {
            return;
        }
        foreach ($params as $key => $value) {
            $qb->andWhere("c.{$key} = :{$key}")
                ->setParameter($key, $value);
        }
    }  
    

    protected function findContentByType($contentType, $page, $params=[])
    {
        $qb = $this->getContentQuery($contentType)
                   ->where('c.status = :status');
        $this->addParams($qb, $params);
        $qb->orderBy('c.datePublished', 'DESC')
           ->setParameter('status',1);

        return $this->paginate($qb->getQuery(), $page);
    } 

    public function findTotalRecords($entityClass)
    {
        return $this->_em->createQueryBuilder()
                 ->select('COUNT(e.id)')
                 ->from($entityClass, 'e')
                 ->getQuery()
                 ->getSingleScalarResult();
    }     

    protected function add24h(\DateTimeInterface $date)
    {
        $interval = '24:00';
        return $date->add(new \DateInterval("P0000-00-00T$interval:00"));
    }         
}