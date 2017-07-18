<?php

namespace Omnipay\PaymentgateRu\OrderBundle;

interface OrderInterface
{
    /**
     * Order's cart.
     *
     * @return OrderItemInterface[]
     */
    public function getItems();

    /**
     * Order's customer.
     *
     * @return CustomerInterface|null
     */
    public function getCustomer();

    /**
     * Order's creation date as a timestamp.
     *
     * @return int|null
     */
    public function getCreationDate();
}
