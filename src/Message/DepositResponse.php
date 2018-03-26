<?php

namespace Omnipay\PaymentgateRu\Message;

class DepositResponse extends AbstractCurlResponse
{
    /**
     * Is the response successful?
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return !$this->data['errorCode'];
    }

    /**
     * Response code
     *
     * @return null|string A response code from the payment gateway
     */
    public function getCode()
    {
        return $this->data['errorCode'];
    }

    /**
     * Response Message
     *
     * @return null|string A response message from the payment gateway
     */
    public function getMessage(): ?string
    {
        return $this->data['errorMessage'];
    }
}
