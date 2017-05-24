<?php

namespace MeritocrateBundle\Repository;

/**
 * SpeechRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SpeechRepository extends \Doctrine\ORM\EntityRepository
{
    public function myFindSpeeches($discussion){
        $qb = $this->createQueryBuilder('s')
            ->where('s.discussion = :discussion')
            ->setParameter('discussion', $discussion)
            ->orderBy('s.id', 'DESC')
            ->getQuery();
        return $qb->getResult();
    }

    public function myFindAll($discussion){
        $qb = $this->createQueryBuilder('s')
            ->where('s.discussion = :discussion')
            ->setParameter('discussion', $discussion)
            ->getQuery();
        return $qb->getResult();
    }

    public function myFindBefore($idLastSpeech, $discussion){
        $qb = $this->createQueryBuilder('s');
        $qb->where('s.id < :start')->setParameter('start', $idLastSpeech)
            ->andWhere('s.discussion = :discussion')->setParameter('discussion', $discussion);
        return $qb->getQuery()->getResult();
    }

    public function myFindBy($idLastSpeech, $discussion, $max)
    {
        $qb = $this->createQueryBuilder('s');
        $qb->select('s.id, s.timestamp')
            ->join('s.user', 'u')
            ->addSelect('u.id as userId, u.fullname, u.picture')
            ->where('s.id > :start')
            ->andWhere('s.discussion = :discussion')
            ->setParameters(array(
                'discussion' => $discussion,
                'start' => $idLastSpeech
            ))
            ->orderBy('s.id', 'DESC')
            ->setMaxResults($max);

        return $qb->getQuery()->getResult();
    }
}
