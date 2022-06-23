<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="orders")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var Customer
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer")
     * @ORM\JoinColumn(name="customer", referencedColumnName="id")
     */
    private Customer $customer;

    /**
     * @var string
     * @ORM\Column(name="order_code", type="string", length=50, nullable=false)
     */
    private string $orderCode;

    /**
     * @var int
     * @ORM\Column(name="order_status", type="integer", length=2)
     */
    private int $orderStatus = 1; // 1: waiting 2: approved, 3: cancelled

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="App\Entity\Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private Product $product;

    /**
     * @var int
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private int $quantity = 1;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text", nullable=false)
     */
    private string $address;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="shipping_date", type="datetime", nullable=false)
     */
    private \DateTime $shippingDate;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return self
     */
    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     * @return self
     */
    public function setCustomer(Customer $customer): self
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrderCode(): string
    {
        return $this->orderCode;
    }

    /**
     * @param string $orderCode
     * @return self
     */
    public function setOrderCode(string $orderCode): self
    {
        $this->orderCode = $orderCode;
        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return self
     */
    public function setProduct(Product $product): self
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return self
     */
    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return self
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getShippingDate(): \DateTime
    {
        return $this->shippingDate;
    }

    /**
     * @param \DateTime $shippingDate
     * @return self
     */
    public function setShippingDate(\DateTime $shippingDate): self
    {
        $this->shippingDate = $shippingDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrderStatus(): string
    {
        return $this->orderStatus;
    }

    /**
     * @param string $orderStatus
     * @return self
     */
    public function setOrderStatus(string $orderStatus): self
    {
        $this->orderStatus = $orderStatus;
        return $this;
    }
}
