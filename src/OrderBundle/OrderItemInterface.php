<?php

namespace Omnipay\RbsUat\OrderBundle;

interface OrderItemInterface
{
    /**
     * Product name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Quantity measure
     *
     * @return string
     */
    public function getMeasure(): string;

    /**
     * Quantity value
     *
     * @return int|float
     */
    public function getQuantity(): float;

    /**
     * Single product price.
     *
     * @return int
     */
    public function getAmount(): int;

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
    public function getDetailParams(): ?iterable;

    /**
     * Product price.
     *
     * @return int|float
     */
    public function getPrice(): float;

    /**
     * Product currency in ISO-4217 format.
     * Currency will be set to rubles if null returned.
     *
     * @return string|null
     */
    public function getCurrency(): ?string;

    /**
     * Discount type ("percent" or "value").
     * Not required, return null if there is no discounts.
     *
     * @return string|null
     */
    public function getDiscountType(): ?string;

    /**
     * Returns discount value.
     * Not required, return null if there is no discounts.
     *
     * @return int|float|null
     */
    public function getDiscountValue(): ?float;
}
