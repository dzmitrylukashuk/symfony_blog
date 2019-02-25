<?php

namespace CommentBundle\Repository;


use Doctrine\ORM\EntityRepository;
use PageBundle\Entity\Page;

class CommentRepository extends EntityRepository {

    const LIMIT_PER_PAGE = 10;

    public function findLastComments(Page $page) {
        $query = $this->createQueryBuilder('c');
        $query
            ->where('c.page = :page')
            ->setParameter('page', $page)
            ->setMaxResults(self::LIMIT_PER_PAGE)
            ->orderBy('c.id', 'DESC');
        return $query->getQuery()->getResult();
    }

    public function countComments(Page $page) {
        $query = $this->createQueryBuilder('c');
        $query
            ->select('count(c.id)')
            ->where('c.page = :page')
            ->setParameter('page', $page);
        return $query->getQuery()->getSingleScalarResult();
    }

}