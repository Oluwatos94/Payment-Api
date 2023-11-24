<?php

namespace PaymentApi\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use PaymentApi\models\A_model;

abstract class A_Repository
{
    /**
     * @param EntityManager $em
     */
    public function __construct(protected EntityManager $em){}

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function store(A_model $model): void
    {
        $this->em->persist($model);
        $this->em->flush($model);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function update(A_model $model): void
    {
        $this->em->persist($model);
        $this->em->flush($model);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function remove(A_model $model): void
    {
        $this->em->remove($model);
        $this->em->flush($model);
    }
}