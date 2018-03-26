<?php

namespace Tests\Examples;

use Omnipay\PaymentgateRu\OrderBundle\OrderItemInterface;
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
    public function getDeliveryType(): ?string
    {
        return 'DHL courier';
    }

    /**
     * 2-symbol country code.
     *
     * @return string
     */
    public function getCountry(): ?string
    {
        return 'RU';
    }

    /**
     * City name.
     *
     * @return string
     */
    public function getCity(): ?string
    {
        return 'Волгоград';
    }

    /**
     * Address.
     *
     * @return string
     */
    public function getPostAddress(): ?string
    {
        return 'ул. Пушкина, д. Колотушкина, 23';
    }

    /**
     * Order's cart.
     *
     * @return iterable
     */
    public function getItems(): iterable
    {
        return [
            new OrderItem(3200000, 'iPhone 6S 64Gb Space Gray', 2),
            new OrderItem(1000000, 'Samsung Galaxy Note II White', 1),
        ];
    }

    /**
     * Order's customer.
     *
     * @return CustomerInterface|null
     */
    public function getCustomer(): ?\Omnipay\PaymentgateRu\OrderBundle\CustomerInterface
    {
        return new Customer();
    }

    /**
     * Order's creation date as a timestamp.
     *
     * @return int|null
     */
    public function getCreationDate(): ?int
    {
        return time();
    }
}
