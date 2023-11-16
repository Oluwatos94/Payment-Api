<?php

namespace PaymentApi\models;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity] #[ORM\Table(name: 'Customers')]
class Customers
{
    #[ORM\id] #[ORM\Column(type: 'integer')] #[ORM\GeneratedValue(Strategy: 'AUTO')]
    private int $id;
    #[ORM\Column(type: 'string', nullable: false)]
    private string $name;
    #[ORM\Column(name: 'is_active', type: 'boolean', nullable: true)]
    private bool $isActive;
    #[ORM\Column(type: 'string', nullable: false)]
    private string $email;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     */
    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}