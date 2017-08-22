<?php

namespace Omnipay\PaymentgateRu\Message;

class PaymentResponse extends AbstractCurlResponse
{
    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->data['success'];
    }

    /**
     * Get order id.
     *
     * @return int|string|null
     */
    public function getOrderId()
    {
        return $this->isSuccessful() ? $this->data['data']['orderId'] : null;
    }

    /**
     * Response Message
     *
     * @return null|string A response message from the payment gateway
     */
    public function getMessage()
    {
        return $this->isSuccessful() ? null : $this->data['error']['message'];
    }

    /**
     * Get error description.
     *
     * @return null|string
     */
    public function getDescription()
    {
        return $this->isSuccessful() ? null : $this->data['error']['description'];
    }

    /**
     * Response code
     *
     * @return int A response code from the payment gateway
     */
    public function getCode()
    {
        return $this->isSuccessful() ? 0 : (int) $this->data['error']['code'];
    }
}
