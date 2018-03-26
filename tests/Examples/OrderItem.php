<?php

namespace Tests\Examples;

use Omnipay\PaymentgateRu\OrderBundle\OrderItemInterface;
use Omnipay\PaymentgateRu\OrderBundle\OrderItemTaxableInterface;

class OrderItem implements OrderItemInterface, OrderItemTaxableInterface
{
    /**
     * Product price.
     *
     * @var int
     */
    protected $price;

    /**
     * Product name.
     *
     * @var string
     */
    protected $name;

    /**
     * Product quantity.
     *
     * @var int
     */
    protected $quantity;

    /**
     * CartItem constructor.
     *
     * @param int $price
     * @param string $name
     * @param int $quantity
     */
    public function __construct($price, $name, $quantity = 1)
    {
        $this->price = $price;
        $this->name = $name;
        $this->quantity = $quantity;
    }

    /**
     * Product name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Quantity measure
     *
     * @return string
     */
    public function getMeasure(): string
    {
        return 'шт';
    }

    /**
     * Quantity value
     *
     * @return int|float
     */
    public function getQuantity(): float
    {
        return $this->quantity;
    }

    /**
     * Single product price.
     *
     * @return int
     */
    public function getAmount(): int
    {
        return $this->getPrice() * $this->getQuantity();
    }

    /**
     * Product price.
     *
     * @return int|float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * Product code. (i.e. id inside your system or article)
     *
     * @return int|string
     */
    public function getCode()
    {
        return preg_replace('/\s/', '', strtolower($this->getName()));
    }

    /**
     * Returns an key-value array of additional item parameters.
     *
     * @return array|null
     */
    public function getDetailParams(): ?iterable
    {
        return [
            'first_prop' => 'some value',
            'second_prop' => 456,
        ];
    }

    /**
     * Product currency in ISO-4217 format.
     * Currency will be set to rubles if null returned.
     *
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return 643;
    }

    /**
     * Discount type ("percent" or "value").
     * Not required, return null if there is no discounts.
     *
     * @return string|null
     */
    public function getDiscountType(): ?string
    {
        return 'percent';
    }

    /**
     * Returns discount value.
     * Not required, return null if there is no discounts.
     *
     * @return int|float|null
     */
    public function getDiscountValue(): ?float
    {
        return $this->getPrice() / 10;
    }

    /**
     * Tax type.
     *
     * @return int
     */
    public function getTaxType(): int
    {
        return self::TAX_TYPE_0;
    }

    /**
     * Tax sum.
     *
     * @return int
     */
    public function getTaxSum(): int
    {
        return $this->getPrice() * 0.18;
    }
}
