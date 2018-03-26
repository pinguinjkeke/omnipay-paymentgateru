<?php

namespace Omnipay\PaymentgateRu\OrderBundle;

interface OrderItemTaxableInterface
{
    /**
     * Tax types.
     */
    public const TAX_TYPE_NO_VAT = 0;
    public const TAX_TYPE_0 = 1;
    public const TAX_TYPE_10 = 2;
    public const TAX_TYPE_18 = 3;
    public const TAX_TYPE_10_110 = 4;
    public const TAX_TYPE_18_118 = 5;

    /**
     * Tax type.
     *
     * @return int
     */
    public function getTaxType(): int;

    /**
     * Tax sum.
     *
     * @return int
     */
    public function getTaxSum(): int;
}
