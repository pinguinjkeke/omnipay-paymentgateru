<?php

namespace Tests\Examples;

use Omnipay\PaymentgateRu\OrderBundle\CartItemInterface;
use Omnipay\PaymentgateRu\OrderBundle\CustomerInterface;
use Omnipay\PaymentgateRu\OrderBundle\OrderDeliverableInterface;
use Omnipay\PaymentgateRu\OrderBundle\OrderInterface;

class Order implements OrderInterface, OrderDeliverableInterface
{
    /**
     * Delivery type.
     *
     * @return string|null
     */
    public function getDeliveryType()
    {
        return 'DHL courier';
    }

    /**
     * 2-symbol country code.
     *
     * @return string
     */
    public function getCountry()
    {
        return 'RU';
    }

    /**
     * City name.
     *
     * @return string
     */
    public function getCity()
    {
        return 'Волгоград';
    }

    /**
     * Address.
     *
     * @return string
     */
    public function getPostAddress()
    {
        return 'ул. Пушкина, д. Колотушкина, 23';
    }

    /**
     * Order's cart.
     *
     * @return CartItemInterface[]
     */
    public function getItems()
    {
        return array(
            new CartItem(3200000, 'iPhone 6S 64Gb Space Gray', 2),
            new CartItem(1000000, 'Samsung Galaxy Note II White', 1)
        );
    }

    /**
     * Order's customer.
     *
     * @return CustomerInterface|null
     */
    public function getCustomer()
    {
        return new Customer();
    }

    /**
     * Order's creation date as a timestamp.
     *
     * @return int|null
     */
    public function getCreationDate()
    {
        return time();
    }
}
