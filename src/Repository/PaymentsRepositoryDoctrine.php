<?php

namespace PaymentApi\Repository;

use Doctrine\ORM\Exception\NotSupported;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use PaymentApi\models\Payments;
use PaymentApi\Repository\PaymentsRepository;

class PaymentsRepositoryDoctrine extends A_Repository implements PaymentsRepository
{

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function save(Payments $payment): void
    {
        $this->em->persist($payment);
        $this->em->flush($payment);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function update(Payments $payment): void
    {   $this->em->persist($payment);
        $this->em->flush($payment);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function remove(Payments $payment): void
    {
        $this->em->remove($payment);
        $this->em->flush($payment);
    }

    /**
     * @throws NotSupported
     */
    public function findById(int $paymentId): Payments|null
    {
        return $this->em->getRepository(Payments::class)->find($paymentId);
    }

    /**
     * @throws NotSupported
     */
    public function findAll(): array
    {
        return $this->em->getRepository(Payments::class)->findAll();
    }
}