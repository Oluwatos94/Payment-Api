<?php

namespace PaymentApi\Repository;

use PaymentApi\models\Payments;

interface PaymentsRepository
{
    public function save(Payments $payment):void ;
    public function update(Payments $payment): void;
    public function remove(Payments $payment): void;
    public function findById(int $paymentId): Payments|null;
    public function findAll(): array;
}