<?php
namespace Invetico\BoabCmsBundle\Repository;

use Invetico\BoabCmsBundle\Repository\BaseRepository;
use Invetico\BoabCmsBundle\Repository\PhotoRepositoryInterface;

class PhotoRepository extends BaseRepository implements PhotoRepositoryInterface
{
    
    public function getAllMedia($page)
    {
      	$qb = $this->getMediaQuery();
        return $this->paginate($qb->getQuery(), $page);
    }


    public function getPhotoByContent($contentId, $page=1)
    {
        $qb = $this->getContentPhotoQueryBuilder()
                   ->where('c.id = :contentId')
                   ->setParameter('contentId', $contentId)
                   ->orderBy('c.dateCreated', 'DESC');
        return $qb->getQuery()->getResult();

        //return $qb->getQuery()->getArrayResult();
        //return $this->paginate(, $page);
    }



    public function getAlbumPhotos($albumSlug, $limit='') 
    {
        //die($albumSlug);
        $qb = $this->getPhotoQueryBuilder()
            ->where('a.galleryId = :galleryId')
            ->orderBy('p.dateCreated', 'DESC')
            ->setParameter('galleryId',$albumSlug)
            ->getQuery();
        return $qb->getSingleResult();        
    }


    public function getMediaByCategory($catId, $page)
    {
    	$qb = $this->getMediaQuery()
    	    ->where('c.id = :catId')
            ->setParameter('catId', $catId)
            ->orderBy('m.dateCreated', 'DESC');
        return $this->paginate($qb->getQuery(), $page);
    }

    private function getContentPhotoQueryBuilder()
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('p','c')
           ->from('BoabCmsBundle:Photo', 'p')
           ->leftJoin('p.content','c');
        return $qb;
    }

    private function getPhotoQueryBuilder()
    {
    	$qb = $this->_em->createQueryBuilder();
    	$qb->select('a','p')
    	   ->from('Invetico\AlbumBundle\Entity\Album', 'a')
    	   ->leftJoin('a.photos','p');
    	return $qb;
    }


    public function findFeaturePhotos($limit)
    {
        $qb = $this->getPhotoQueryBuilder()
            ->orderBy('p.dateCreated', 'DESC')
            ->getQuery()
            ->setFirstResult(0)
            ->setMaxResults($limit);

        return $qb->getResult();
    }


    public function findFeaturedMedia()
    {
        $qb = $this->getMediaQuery()
            ->orderBy('m.dateCreated', 'DESC')
            ->setMaxResults(1);

        return $qb->getQuery()->getSingleResult();
    }

}