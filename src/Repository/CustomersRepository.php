<?php

namespace PaymentApi\Repository;

use PaymentApi\models\Customers;

interface CustomersRepository
{
    public function save(Customers $customer):void ;
    public function update(Customers $customer): void;
    public function remove(Customers $customer): void;
    public function findById(int $customerId): Customers|null;
    public function findAll(): array;
}