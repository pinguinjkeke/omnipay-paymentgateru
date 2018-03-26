<?php

namespace Omnipay\PaymentgateRu\OrderBundle;

interface OrderInterface
{
    /**
     * Order's cart.
     *
     * @return iterable|\Omnipay\PaymentgateRu\OrderBundle\OrderItemInterface[]
     */
    public function getItems(): iterable;

    /**
     * Order's customer.
     *
     * @return CustomerInterface|null
     */
    public function getCustomer(): ?CustomerInterface;

    /**
     * Order's creation date as a timestamp.
     *
     * @return int|null
     */
    public function getCreationDate(): ?int;
}
