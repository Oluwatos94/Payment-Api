<?php

namespace PaymentApi\Repository;

use Doctrine\ORM\EntityManager;

abstract class A_Repository
{
    /**
     * @param EntityManager $em
     */
    public function __construct(protected EntityManager $em){}
}