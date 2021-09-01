<?php

namespace Omnipay\RbsUat\Message;

class AddParamsResponse extends AbstractCurlResponse
{
    /**
     * Is the response successful?
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return !$this->getCode();
    }

    /**
     * Response code
     *
     * @return int|string A response code from the payment gateway
     */
    public function getCode()
    {
        return (int) $this->data['errorCode'];
    }
}
