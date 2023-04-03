<?php

namespace App\Entity;

use App\Repository\VatCalculationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VatCalculationRepository::class)
 */
class VatCalculation
{

    public function __construct(
        float $value,
        float $rate,
        bool $isInclusive,
        float $valueExVat,
        float $valueIncVat,
        float $vatAmount
    ) {
        $this->value = $value;
        $this->rate = $rate;
        $this->isInclusive = $isInclusive;
        $this->valueExVat = $valueExVat;
        $this->valueIncVat = $valueIncVat;
        $this->vatAmount = $vatAmount;
        $this->createdAt = new \DateTimeImmutable();
    }
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $value;

    /**
     * @ORM\Column(type="float")
     */
    private $rate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isInclusive;

    /**
     * @ORM\Column(type="float")
     */
    private $valueExVat;

    /**
     * @ORM\Column(type="float")
     */
    private $valueIncVat;

    /**
     * @ORM\Column(type="float")
     */
    private $vatAmount;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getIsInclusive(): ?bool
    {
        return $this->isInclusive;
    }

    public function setIsInclusive(bool $isInclusive): self
    {
        $this->isInclusive = $isInclusive;

        return $this;
    }

    public function getValueExVat(): ?float
    {
        return $this->valueExVat;
    }

    public function setValueExVat(float $valueExVat): self
    {
        $this->valueExVat = $valueExVat;

        return $this;
    }

    public function getValueIncVat(): ?float
    {
        return $this->valueIncVat;
    }

    public function setValueIncVat(float $valueIncVat): self
    {
        $this->valueIncVat = $valueIncVat;

        return $this;
    }

    public function getVatAmount(): ?float
    {
        return $this->vatAmount;
    }

    public function setVatAmount(float $vatAmount): self
    {
        $this->vatAmount = $vatAmount;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
