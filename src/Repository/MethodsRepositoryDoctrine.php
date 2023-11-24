<?php

namespace PaymentApi\Repository;

use Doctrine\ORM\Exception\NotSupported;
use PaymentApi\models\methods;

class MethodsRepositoryDoctrine extends A_Repository implements MethodsRepository
{
    /**
     * @param int $methodId
     * @return methods|null
     * @throws NotSupported
     */
    public function findById(int $methodId): Methods|null
    {
        return $this->em->getRepository(Methods::class)->find($methodId);
    }

    /**
     * @return array
     * @throws NotSupported
     */
    public function findAll(): array
    {
        return $this->em->getRepository(Methods::class)->findAll();
    }
}