<?php

namespace Tests\Examples;

use Omnipay\PaymentgateRu\OrderBundle\CustomerInterface;

class Customer implements CustomerInterface
{
    /**
     * Customer's email.
     *
     * @return string
     */
    public function getEmail()
    {
        return 'yaavakov@gmail.com';
    }

    /**
     * Customer's phone.
     *
     * @return string
     */
    public function getPhone()
    {
        return '88002000600';
    }

    /**
     * Customer's another contact method.
     *
     * @return string
     */
    public function getContact()
    {
        return 'Fax: 4321432194';
    }
}
