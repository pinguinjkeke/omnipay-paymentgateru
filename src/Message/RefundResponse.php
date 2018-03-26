<?php

namespace Omnipay\PaymentgateRu\Message;

class RefundResponse extends AbstractCurlResponse
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
     * @return int A response code from the payment gateway
     */
    public function getCode(): int
    {
        return (int) $this->data['errorCode'];
    }

    /**
     * Response message
     *
     * @return string
     */
    public function getMessage(): ?string
    {
        return $this->data['errorMessage'];
    }
}
