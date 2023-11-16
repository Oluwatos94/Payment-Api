<?php

namespace PaymentApi\Repository;

use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use paymentApi\models\methods;
use PaymentApi\Repository\MethodsRepository;

class MethodsRepositoryDoctrine extends A_Repository implements MethodsRepository
{

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function save(methods $method): void
    {
        $this->em->persist($method);
        $this->em->flush($method);
    }

    /**
     * @param methods $method
     * @return void
     * @throws \Doctrine\ORM\Exception\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(Methods $method): void
    {
        $this->em->persist($method);
        $this->em->flush($method);
    }

    /**
     * @param methods $method
     * @return void
     * @throws \Doctrine\ORM\Exception\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(methods $method): void
    {
        $this->em->remove($method);
        $this->em->flush($method);
    }

    /**
     * @param int $methodId
     * @return methods|null
     * @throws \Doctrine\ORM\Exception\NotSupported
     */

    /**
     * @param int $methodId
     * @return methods|null
     * @throws \Doctrine\ORM\Exception\NotSupported
     */
    public function findById(int $methodId): Methods|null
    {
        return $this->em->getRepository(Methods::class)->find($methodId);
    }

    /**
     * @return array
     * @throws \Doctrine\ORM\Exception\NotSupported
     */
    public function findAll(): array
    {
        return $this->em->getRepository(Methods::class)->findAll();
    }
}