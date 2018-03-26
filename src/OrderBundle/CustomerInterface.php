<?php

namespace Omnipay\PaymentgateRu\OrderBundle;

/**
 * Interface CustomerInterface.
 * Apply this interface to your Customer class (i.e. model).
 *
 * @author Alexander Avakov (pinguinjkeke)
 * @company Meshgroup
 * @package Omnipay\PaymentgateRu
 */
interface CustomerInterface
{
    /**
     * Customer's email.
     *
     * @return string
     */
    public function getEmail(): ?string;

    /**
     * Customer's phone.
     *
     * @return string
     */
    public function getPhone(): ?string;

    /**
     * Customer's another contact method.
     *
     * @return string
     */
    public function getContact(): ?string;
}
