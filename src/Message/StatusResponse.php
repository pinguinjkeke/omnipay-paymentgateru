<?php

namespace Omnipay\PaymentgateRu\Message;

class StatusResponse extends AbstractCurlResponse
{
    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return (int) $this->data['ErrorCode'] === 0;
    }

    /**
     * Response code
     *
     * @return int A response code from the payment gateway
     */
    public function getCode()
    {
        return (int) $this->data['ErrorCode'];
    }

    /**
     * Response Message
     *
     * @return string A response message from the payment gateway
     */
    public function getMessage()
    {
        return $this->data['ErrorMessage'];
    }

    /**
     * Order status
     *
     * @return int
     */
    public function getOrderStatus()
    {
        return (int) $this->data['OrderStatus'];
    }

    /**
     * Your application's order id
     * 
     * @return mixed
     */
    public function getOrderNumber()
    {
        return $this->data['OrderNumber'];
    }

    /**
     * Masked card number (only when order paid)
     * 
     * @return string
     */
    public function getCardPan()
    {
        return array_key_exists('Pan', $this->data) ? $this->data['Pan'] : null;
    }

    /**
     * Card expiration date (only when order paid)
     * 
     * @return string
     */
    public function getCardExpiration()
    {
        return array_key_exists('expiration', $this->data) ? $this->data['expiration'] : null;
    }

    /**
     * Card holder (only when order paid)
     * 
     * @return string
     */
    public function getCardHolder()
    {
        return array_key_exists('cardholderName', $this->data) ? $this->data['cardholderName'] : null;
    }

    /**
     * Order sum
     * 
     * @return int
     */
    public function getAmount()
    {
        return (int) $this->data['Amount'];
    }

    /**
     * Order currency in ISO 4217 format
     * 
     * @return int
     */
    public function getCurrency()
    {
        return (int) $this->data['currency'];
    }

    /**
     * Approval code
     * 
     * @return string
     */
    public function getApprovalCode()
    {
        return $this->data['approvalCode'];
    }

    /**
     * Client's IP-address
     * 
     * @return string
     */
    public function getIp()
    {
        return $this->data['Ip'];
    }

    /**
     * Order creation date
     * 
     * @return string
     */
    public function getDate()
    {
        return array_key_exists('date', $this->data) ? $this->data['date'] : null;
    }

    /**
     * Client id (if used)
     * 
     * @return string
     */
    public function getClientId()
    {
        return array_key_exists('clientId', $this->data) ? $this->data['clientId'] : null;
    }

    /**
     * Binding id (if used)
     * 
     * @return string
     */
    public function getBindingId()
    {
        return array_key_exists('bindingId', $this->data) ? $this->data['bindingId'] : null;
    }
}
