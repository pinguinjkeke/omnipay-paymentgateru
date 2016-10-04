<?php

namespace Omnipay\PaymentgateRu\Message;

class AddParamsResponse extends AbstractCurlResponse
{
    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->getCode() === 0;
    }

    /**
     * Response code
     *
     * @return int A response code from the payment gateway
     */
    public function getCode()
    {
        return (int)$this->data['errorCode'];
    }
}
