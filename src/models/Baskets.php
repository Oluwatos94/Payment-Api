<?php

namespace PaymentApi\models;

use Doctrine\ORM\Mapping as ORM;
use PaymentApi\models\A_model;

#[ORM\Entity, ORM\Table(name: 'baskets')]
class Baskets extends A_model
{
    #[ORM\Id, ORM\Column(type: 'Integer'), ORM\GeneratedValue(Strategy:'AUTO')]
    private int $id;
    #[ORM\Column(name:'product_name', type:'string', nullable: false)]
    private string $productName;
    #[ORM\Column(name:'product_Gtin', type:'string', nullable: false)]
    private string $productGtin;
    #[ORM\Column(type:'integer', nullable: false)]
    private int $quantity;
    #[ORM\Column(name:'customer_id', type:'integer', nullable: false)]
    private int $customerId;
    #[ORM\Column(name:'total_price', type:'float', nullable: false)]
    private float $totalPrice;
    #[ORM\ManyToOne(targetEntity: Customers::Class, inversedBy: "Baskets")]
    #[ORM\JoinColumn(name: "customer_id", referencedColumnName: "id")]
    private Customers $customer;

    public function getCustomer(): Customers
    {
        return $this->customer;
    }

    public function setCustomer(Customers $customer): void
    {
        $this->customer = $customer;
    }

    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): void
    {
        $this->totalPrice = $totalPrice;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function setCustomerId(int $customerId): void
    {
        $this->customerId = $customerId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getProductGtin(): string
    {
        return $this->productGtin;
    }

    public function setProductGtin(string $productGtin): void
    {
        $this->productGtin = $productGtin;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): void
    {
        $this->productName = $productName;
    }

    public function getId(): int
    {
        return $this->id;
    }


}