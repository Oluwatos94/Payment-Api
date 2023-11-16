<?php

namespace PaymentApi\models;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity] #[ORM\Table(name: 'methods')]
class Methods
{
    #[ORM\Id] #[ORM\column(type: 'integer')] #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;
    #[ORM\Column(type: 'string', unique: true, nullable: false)]
    private string $name;
    #[ORM\Column(name: 'is_active', type: 'boolean', nullable: false)]
    private bool $isActive;

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
}