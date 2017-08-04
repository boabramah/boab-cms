<?php
namespace Invetico\BoabCmsBundle\Repository;

use Invetico\BoabCmsBundle\Repository\BaseRepository;
use Invetico\PageBundle\Entity\PageInterface;
use Invetico\BoabCmsBundle\Entity\ParentableInterface;
use Doctrine\ORM\Query\ResultSetMapping;

class ContentRepository extends BaseRepository implements ContentRepositoryInterface
{

    public function getAllContents($page)
    {
          $qb = $this->getContentQuery()
            ->orderBy('c.dateCreated', 'DESC');

        return $this->paginate($qb->getQuery(), $page, 10);
    }    


    public function findContentsForApi($start, $limit)
    {
          $qb = $this->getContentQuery()
            ->orderBy('c.dateCreated', 'DESC')
            ->getQuery()
            ->setFirstResult($start)
            ->setMaxResults($limit);

        return $qb->getResult();
    }

    public function findContentBySearchTerm($criteria)
    {
        $qb = $this->getContentQuery();
        $qb->where('c.title LIKE :criteria')
          ->orWhere('c.summary LIKE :criteria')
          ->setParameter('criteria', '%'.$criteria.'%');
      return $qb->getQuery()->getResult();         
    }

    public function findAllContentByType($contentType)
    {
        $qb = $this->getContentQuery($contentType)
            ->orderBy('c.dateCreated', 'DESC');

        return $qb->getQuery()->getResult();
    }

    public function findContentById($id)
    {
        $qb = $this->getContentQuery()
                    ->where('c.id = :id')
                    ->setParameter('id',$id);

        return $qb->getQuery()->getOneOrNullResult();
    }
    

    public function findContentByRouteId($id)
    {
        $qb = $this->getContentQuery()
            ->where('m.id = :id')
            ->andWhere('c.status = :status')
            ->setParameter('id',$id)
            ->setParameter('status',1);

        return $qb->getQuery()->getOneOrNullResult();
    }


    public function findContentBySlug($slug)
    {
        $qb = $this->getContentQuery()
            ->where('c.slug = :slug')
            ->andWhere('c.status = :status')
            ->setParameter('slug',$slug)
            ->setParameter('status',1);

        return $qb->getQuery()->getOneOrNullResult();
    }


    public function findContentByUserId($userId)
    {
        $qb = $this->getContentQuery()
            ->where('u.id = :id')
            ->setParameter('id',$userId);

        return $qb->getQuery()->getResult();
    }

    public function findLatestContent($contentType, $limit)
    {
        $qb = $this->getContentQuery($contentType)
            ->where('c.status = :status')
            ->orderBy('c.datePublished', 'DESC')
            ->setParameter('status',1)
            ->getQuery()
            ->setFirstResult(0)
            ->setMaxResults($limit);

        return $qb->getResult();
    }

    public function findRelatedContentType($contentType, $limit, $excludeIds=[])
    {
        $ids = implode(',',$excludeIds);
        $qb = $this->getContentQuery($contentType)
            ->where('c.status = :status')
            ->andWhere('c.id NOT IN (:ids)')
            ->orderBy('c.datePublished', 'DESC')
            ->setParameter('status',1)
            ->setParameter('ids', $ids)
            ->getQuery()
            ->setFirstResult(0)
            ->setMaxResults($limit);

        return $qb->getResult();

        /*
        $nots = $qb->select('sub_c')
          ->from($contentType, 'sub_c')
          ->where($qb->expr()->eq('sub_c.id',1))
          ->getQuery()
          ->getResult();
        $linked = $qb->select('rl')
             ->from('MineMyBundle:MineRequestLine', 'rl')
             ->where($qb->expr()->notIn('rl.request_id', $nots))
             ->getQuery()
             ->getResult();
        */
    }

    public function findContentByTerm($contentType, $term, $page)
    {
        $qb = $this->getContentQuery($contentType);
        $qb->where('t.slug = :slug')
            ->andWhere('c.status = :status')
            ->setParameter('slug', $term)
            ->setParameter('status', 1)
            ->orderBy('c.datePublished', 'DESC');

        return $this->paginate($qb->getQuery(), $page);
    }


    public function findFeaturedContent()
    {
        $qb = $this->getContentQuery()
            ->where('c.isFeatured = :featured')
            ->andWhere('c.status = :status')
            ->setParameter('featured',1)
            ->setParameter('status',1)
            ->setFirstResult(0)
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function findFeaturedContentType($contentType, $limit)
    {
        $qb = $this->getContentQuery($contentType)
            ->where('c.status = :status')
            ->setParameter('status',1)
            ->setFirstResult(0)
            ->setMaxResults($limit);
        return $qb->getQuery()->getOneOrNullResult();
    }    

    public function getPromotedContents()
    {
        $qb = $this->getContentQuery()
            ->where('c.promoted = :promoted')
            ->andWhere('c.status = :status')
            ->setParameter('promoted',1)
            ->setParameter('status',1)
            ->orderBy('c.datePublished', 'DESC');

        return $qb->getQuery()->getResult();
    }

    public function findChildContentsByParent(ParentableInterface $content, $limit=0)
    {
        $qb = $this->getContentQuery('Invetico\BoabCmsBundle\Entity\Content')
            ->where('c.parentId = :parentId')
            ->andWhere('c.status = :status')
            ->setParameter('parentId', $content->getId())
            ->setParameter('status',1)
            ->orderBy('c.datePublished', 'DESC');
        if($limit > 0){
            $qb->setFirstResult(0)
            ->setMaxResults($limit); 
        }

        return $qb->getQuery()->getResult();
    }

    public function findPublishedContentByType($contentType, $page, $params=[])
    {  
        $qb = $this->getContentQuery($contentType)
                ->where('c.status = :status');
        $this->addParams($qb, $params);
        $qb->orderBy('c.datePublished', 'DESC')
                ->setParameter('status',1);

        return $this->paginate($qb->getQuery(), $page);      
    } 



    public function findContentByEntities($entityClasses, $page)    
    {
        $dql = $this->getContentByEntitiesDql($entityClasses);
        $qb = $this->createQuery($dql);
        $qb->setParameter('status',1);
        return $this->paginate($qb, $page);            
    }


    private function getContentByEntitiesDql($entityClasses)
    {
        $dql = sprintf('SELECT c, m, u
                FROM BoabCmsBundle:Content c
                LEFT JOIN c.menu m
                LEFT JOIN c.user u
                WHERE (c INSTANCE OF %s)
                AND c.status = :status
                ORDER BY c.datePublished DESC', 
                implode(' OR c INSTANCE OF ', $entityClasses));
        return $dql;        
    }


    public function findContentByEntitiesWidget($entityClasses, $limit=3)
    {
        $dql = $this->getContentByEntitiesDql($entityClasses);
        $qb = $this->createQuery($dql);
        $qb->setParameter('status',1)
           ->setFirstResult(0)
           ->setMaxResults($limit); 
        return $qb->getResult();
    }


    public function hasChildContents(ParentableInterface $page)
    {
        $query = $this->_em->createQueryBuilder()
            ->select('COUNT(c.id)')
            ->from('Invetico\BoabCmsBundle\Entity\Content', 'c')
            ->where('c.parentId = :parentId')
            ->setParameter('parentId', $page->getId());

        return $query->getQuery()->getSingleScalarResult();
    }

    public function findContentCount()
    {
        $query = $this->_em->createQueryBuilder()
            ->select('COUNT(c.id)')
            ->from('Invetico\BoabCmsBundle\Entity\Content', 'c');

        return $query->getQuery()->getSingleScalarResult();
    }    

    public function findContentsByParentId($parentId, $limit=0, $dateOrder)
    {
        $qb = $this->getContentQuery('Invetico\BoabCmsBundle\Entity\Content')
            ->where('c.parentId = :parentId')
            ->andWhere('c.status = :status')
            ->setParameter('parentId', $parentId)
            ->setParameter('status',1)
            ->orderBy('c.datePublished', $dateOrder);
        if($limit > 0){
            $qb->setFirstResult(0)
            ->setMaxResults($limit); 
        }
        return $qb->getQuery()->getResult();
    } 

    public function findTotalContentByYear()
    {
        $sql = "SELECT 
                    c.content_type AS type, 
                    count(c.id) as count  
                FROM contents c 
                GROUP BY type";


        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('type', 'type');
        $rsm->addScalarResult('count', 'count');
        $query = $this->_em->createNativeQuery($sql, $rsm);
        return $query->getResult();


        //$dql = 'SELECT SUBSTRING(c.dateCreated, 1, 4) AS year, count(c) as total  FROM BoabCmsBundle:Content c GROUP BY year';
        $dql = 'SELECT c.discr AS type, count(c) as total  FROM BoabCmsBundle:Content c GROUP BY type';
        $query = $this->_em->createQuery($dql);
        return $query->getArrayResult();
        //return $query->getResult();
    }
        
}
