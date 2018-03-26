<?php

namespace Omnipay\PaymentgateRu\Message;

class ReverseResponse extends AbstractCurlResponse
{
    /**
     * Is the response successful?
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return (int) $this->data['errorCode'] === 0;
    }

    /**
     * Response code
     *
     * @return int A response code from the payment gateway
     */
    public function getCode(): int
    {
        return (int) $this->data['errorCode'];
    }

    /**
     * Response Message
     *
     * @return string A response message from the payment gateway
     */
    public function getMessage(): ?string
    {
        return $this->data['errorMessage'];
    }
}
