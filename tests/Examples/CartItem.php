<?php

namespace Tests\Examples;

use Omnipay\PaymentgateRu\OrderBundle\CartItemInterface;
use Omnipay\PaymentgateRu\OrderBundle\CartItemTaxableInterface;

class CartItem implements CartItemInterface, CartItemTaxableInterface
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * Quantity measure
     *
     * @return string
     */
    public function getMeasure()
    {
        return 'шт';
    }

    /**
     * Quantity value
     *
     * @return int|float
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Single product price.
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->getPrice() * $this->getQuantity();
    }

    /**
     * Product price.
     *
     * @return int|float
     */
    public function getPrice()
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
    public function getDetailParams()
    {
        return array(
            'first_prop' => 'some value',
            'second_prop' => 456
        );
    }

    /**
     * Product currency in ISO-4217 format.
     * Currency will be set to rubles if null returned.
     *
     * @return string|null
     */
    public function getCurrency()
    {
        return 643;
    }

    /**
     * Discount type ("percent" or "value").
     * Not required, return null if there is no discounts.
     *
     * @return string|null
     */
    public function getDiscountType()
    {
        return 'percent';
    }

    /**
     * Returns discount value.
     * Not required, return null if there is no discounts.
     *
     * @return int|float|null
     */
    public function getDiscountValue()
    {
        return $this->getPrice() / 10;
    }

    /**
     * Tax type.
     *
     * @return int
     */
    public function getTaxType()
    {
        return self::TAX_TYPE_0;
    }

    /**
     * Tax sum.
     *
     * @return int
     */
    public function getTaxSum()
    {
        return $this->getPrice() * 0.18;
    }
}
