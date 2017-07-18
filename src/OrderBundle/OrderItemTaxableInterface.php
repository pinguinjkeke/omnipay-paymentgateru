<?php

namespace Omnipay\PaymentgateRu\OrderBundle;

interface OrderItemTaxableInterface
{
    /**
     * Tax types.
     */
    const TAX_TYPE_NO_VAT = 0;
    const TAX_TYPE_0 = 1;
    const TAX_TYPE_10 = 2;
    const TAX_TYPE_18 = 3;
    const TAX_TYPE_10_110 = 4;
    const TAX_TYPE_18_118 = 5;

    /**
     * Tax type.
     *
     * @return int
     */
    public function getTaxType();

    /**
     * Tax sum.
     *
     * @return int
     */
    public function getTaxSum();
}
