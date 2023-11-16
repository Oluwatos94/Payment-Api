<?php

namespace PaymentApi\Repository;
use paymentApi\models\methods;
interface MethodsRepository
{
    public function save(Methods $method):void ;
    public function update(Methods $method): void;
    public function remove(Methods $method): void;
    public function findById(int $methodId): Methods|null;
    public function findAll(): array;

}