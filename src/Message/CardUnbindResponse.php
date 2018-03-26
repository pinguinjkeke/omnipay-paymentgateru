<?php

namespace Omnipay\PaymentgateRu\Message;

class CardUnbindResponse extends AbstractCurlResponse
{
    /**
     * Is the response successful?
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->getCode() === 0;
    }

    /**
     * Response code
     *
     * @return null|int A response code from the payment gateway
     */
    public function getCode(): ?int
    {
        return (int) $this->data['errorCode'];
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
