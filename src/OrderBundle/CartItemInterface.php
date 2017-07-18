<?php

namespace Omnipay\PaymentgateRu\OrderBundle;

interface CartItemInterface
{
    /**
     * Product name.
     *
     * @return string
     */
    public function getName();

    /**
     * Quantity measure
     *
     * @return string
     */
    public function getMeasure();

    /**
     * Quantity value
     *
     * @return int|float
     */
    public function getQuantity();

    /**
     * Single product price.
     *
     * @return int
     */
    public function getAmount();

    /**
     * Product code. (i.e. id inside your system or article)
     *
     * @return int|string
     */
    public function getCode();

    /**
     * Returns an key-value array of additional item parameters.
     *
     * @return array|null
     */
    public function getDetailParams();

    /**
     * Product price.
     *
     * @return int|float
     */
    public function getPrice();

    /**
     * Product currency in ISO-4217 format.
     * Currency will be set to rubles if null returned.
     *
     * @return string|null
     */
    public function getCurrency();

    /**
     * Discount type ("percent" or "value").
     * Not required, return null if there is no discounts.
     *
     * @return string|null
     */
    public function getDiscountType();

    /**
     * Returns discount value.
     * Not required, return null if there is no discounts.
     *
     * @return int|float|null
     */
    public function getDiscountValue();
}
