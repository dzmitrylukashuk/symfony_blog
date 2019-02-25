<?php

namespace PageBundle\Repository;


use Doctrine\ORM\EntityRepository;

class PageRepository extends EntityRepository {

    const PAGES_LIMIT = 2;

    public function findPages($page = 1) {
        $query = $this->createQueryBuilder('p');
        $query
            ->setMaxResults(self::PAGES_LIMIT)
            ->setFirstResult(self::PAGES_LIMIT * ($page - 1));

        return $query->getQuery()->getResult();
    }

    public function countPage() {
        $query = $this->createQueryBuilder('p');
        $query->select('count(p.id)');
        return $query->getQuery()->getSingleScalarResult();
    }

}