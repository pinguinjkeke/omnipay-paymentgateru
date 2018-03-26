<?php

namespace Omnipay\PaymentgateRu\OrderBundle;

/**
 * Interface CustomerDeliverableInterface.
 * Apply this interface to your Customer class (i.e. model) if you can provide any delivery information.
 *
 * @author Alexander Avakov (pinguinjkeke)
 * @company Meshgroup
 * @package Omnipay\PaymentgateRu
 */
interface OrderDeliverableInterface
{
    /**
     * Delivery type.
     *
     * @return string|null
     */
    public function getDeliveryType(): ?string;

    /**
     * 2-symbol country code.
     *
     * @return string
     */
    public function getCountry(): ?string;

    /**
     * City name.
     *
     * @return string
     */
    public function getCity(): ?string;

    /**
     * Address.
     *
     * @return string
     */
    public function getPostAddress(): ?string;
}
