<?php

namespace Omnipay\PaymentgateRu\Message;

class StatusResponse extends AbstractCurlResponse
{
    /**
     * Is the response successful?
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return (int) $this->data['ErrorCode'] === 0;
    }

    /**
     * Response code
     *
     * @return int A response code from the payment gateway
     */
    public function getCode(): int
    {
        return (int) $this->data['ErrorCode'];
    }

    /**
     * Response Message
     *
     * @return string A response message from the payment gateway
     */
    public function getMessage(): ?string
    {
        return $this->data['ErrorMessage'];
    }

    /**
     * Order status
     *
     * @return int
     */
    public function getOrderStatus(): int
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
    public function getCardPan(): ?string
    {
        return $this->data['Pan'] ?? null;
    }

    /**
     * Card expiration date (only when order paid)
     * 
     * @return string
     */
    public function getCardExpiration(): ?string
    {
        return $this->data['expiration'] ?? null;
    }

    /**
     * Card holder (only when order paid)
     * 
     * @return string
     */
    public function getCardHolder(): ?string
    {
        return $this->data['cardholderName'] ?? null;
    }

    /**
     * Order sum
     * 
     * @return int
     */
    public function getAmount(): int
    {
        return (int) $this->data['Amount'];
    }

    /**
     * Order currency in ISO 4217 format
     * 
     * @return int
     */
    public function getCurrency(): int
    {
        return (int) $this->data['currency'];
    }

    /**
     * Approval code
     * 
     * @return string
     */
    public function getApprovalCode(): ?string
    {
        return $this->data['approvalCode'];
    }

    /**
     * Client's IP-address
     * 
     * @return string
     */
    public function getIp(): ?string
    {
        return $this->data['Ip'];
    }

    /**
     * Order creation date
     * 
     * @return string
     */
    public function getDate(): ?string
    {
        return $this->data['date'] ?? null;
    }

    /**
     * Client id (if used)
     * 
     * @return string
     */
    public function getClientId(): ?string
    {
        return $this->data['clientId'] ?? null;
    }

    /**
     * Binding id (if used)
     * 
     * @return string
     */
    public function getBindingId(): ?string
    {
        return $this->data['bindingId'] ?? null;
    }
}
