<?php

namespace PaymentApi\models;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity] #[ORM\Table(name: 'payments')]
class Payments extends A_model
{
    #[ORM\Id, ORM\Column(type: 'integer'), ORM\GeneratedValue(strategy:'AUTO')]
    private int $id;
    #[ORM\Column(name: 'methods_id', type: 'integer', nullable: false)]
    private int $methodId;
    #[ORM\Column(name: 'customer_id', type: 'integer', nullable: false)]
    private int $customerId;
    #[ORM\Column(name: 'Amount_Paid', type: 'float', nullable: false)]
    private float $amount;
    #[ORM\Column(name: 'is_completed', type: 'boolean', nullable: false)]
    private bool $isCompleted;
    #[ORM\Column(name: 'Transaction_date', type: 'date', nullable: false)]
    private string $transactionDate;
    #[ORM\manyToOne(targetEntity: Customers::Class, inversedBy: "payments")]
    #[ORM\JoinColumn(name: "customer_Id", referencedColumnName: "id")]
    private Customers $customer;
    #[ORM\manyToOne(targetEntity: Methods::Class, inversedBy: "payments")]
    #[ORM\JoinColumn(name: "method_Id", referencedColumnName: "id")]
    private Methods $method;
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    /**
     * @param int $customerId
     */
    public function setCustomersId(int $customerId): void
    {
        $this->customerId = $customerId;
    }

    /**
     * @return int
     */
    public function getMethodId(): int
    {
        return $this->methodId;
    }

    /**
     * @param int $methodId
     */
    public function setMethodId(int $methodId): void
    {
        $this->methodId = $methodId;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getTransactionDate(): string
    {
        return $this->transactionDate;
    }

    /**
     * @param string $transactionDate
     */
    public function setTransactionDate(string $transactionDate): void
    {
        $this->transactionDate = $transactionDate;
    }

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->isCompleted;
    }

    /**
     * @param bool $isCompleted
     */
    public function setIsCompleted(bool $isCompleted): void
    {
        $this->isCompleted = $isCompleted;
    }

    public function getCustomer(): Customers
    {
        return $this->customer;
    }

    public function getMethod(): Methods
    {
        return $this->method;
    }
    public function setMethod(Methods $method): void
    {
        $this->method = $method;
    }

    public function setCustomer(Customers $customer): void
    {
        $this->customer = $customer;
    }

}