<?php

namespace App\Entity;

use App\Repository\OrderRowRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRowRepository::class)
 */
class OrderRow
{

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Product::class)
     */
    private $product;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="orderRows")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderItem;

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getOrderItem(): ?Order
    {
        return $this->orderItem;
    }

    public function setOrderItem(?Order $orderItem): self
    {
        $this->orderItem = $orderItem;

        return $this;
    }
}