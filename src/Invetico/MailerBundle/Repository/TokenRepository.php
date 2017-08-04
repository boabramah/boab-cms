<?php
namespace Invetico\MailerBundle\Repository;

use Invetico\BoabCmsBundle\Repository\BaseRepository;


class TokenRepository extends BaseRepository implements TokenRepositoryInterface
{
	public function findByToken($token)
	{
        $qb = $this->getTokenQuery()
            ->where("t.token = :token")
            ->setParameter('token',$token);        
        return $qb->getQuery()->getOneOrNullResult();
	}

    private function getTokenQuery()
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('t')
           ->from('MailerBundle:MailToken', 't');
          return $qb;        
    }

}
