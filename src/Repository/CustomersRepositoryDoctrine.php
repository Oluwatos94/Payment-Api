<?php

namespace PaymentApi\Repository;


use Doctrine\ORM\Exception\NotSupported;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use PaymentApi\models\Customers;
use PaymentApi\Repository\CustomersRepository;

 class CustomersRepositoryDoctrine extends A_Repository implements CustomersRepository
{
    /**
     * @throws NotSupported
     */
    public function findById(int $customerId): Customers|null
    {
        return $this->em->getRepository(Customers::class)->find($customerId);
    }

    /**
     * @throws NotSupported
     */
    public function findAll(): array
    {
        return $this->em->getRepository(Customers::class)->findAll();
    }
}