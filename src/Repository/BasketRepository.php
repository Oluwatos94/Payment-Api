<?php

namespace PaymentApi\Repository;


use PaymentApi\models\Baskets;

interface BasketRepository
{
    public function save(Baskets $Basket):void ;
    public function update(Baskets $Basket): void;
    public function remove(Baskets  $Basket): void;
    public function findById(int  $BasketId): Baskets|null;
    public function findAll(): array;
}