<?php

namespace PaymentApi\Repository;

use Doctrine\ORM\Exception\NotSupported;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use PaymentApi\models\Baskets;

class BasketsRepositoryDoctrine extends A_Repository implements BasketRepository
{

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function save(Baskets $Basket): void
    {
        $this->em->persist($Basket);
        $this->em->flush($Basket);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function update(Baskets $Basket): void
    {
        $this->em->persist($Basket);
        $this->em->flush($Basket);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function remove(Baskets $Basket): void
    {
        $this->em->remove($Basket);
        $this->em->flush($Basket);
    }

    /**
     * @throws NotSupported
     */
    public function findById(int $BasketId): Baskets|null
    {
        return $this->em->getRepository(Baskets::class)->find($BasketId);
    }

    /**
     * @throws NotSupported
     */
    public function findAll(): array
    {
        return $this->em->getRepository(Baskets::class)->findAll();
    }
}