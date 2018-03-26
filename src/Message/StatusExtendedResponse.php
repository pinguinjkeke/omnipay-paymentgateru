<?php

namespace Omnipay\PaymentgateRu\Message;

class StatusExtendedResponse extends AbstractCurlResponse
{
    /**
     * Get value from merchantOrderParams key-value array
     * 
     * @param string $parameter
     * @return null|string
     */
    protected function getMerchantOrderParam($parameter): ?string
    {
        if (array_key_exists('merchantOrderParams', $this->data)) {
            foreach ((array) $this->data['merchantOrderParams'] as $pair) {
                if ($parameter === $pair['name']) {
                    return $pair['value'];
                }
            }
        }
        
        return null;
    }

    /**
     * Return data value or null
     *
     * @param string $parameter
     * @return mixed
     */
    protected function getDataValueOrNull($parameter)
    {
        return $this->data[$parameter] ?? null;
    }

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

    /**
     * Your application's order number
     *
     * @return string
     */
    public function getOrderNumber(): ?string
    {
        return $this->data['orderNumber'];
    }

    /**
     * Order status
     *
     * @return int
     */
    public function getOrderStatus(): int
    {
        return (int) $this->data['orderStatus'];
    }

    /**
     * Action code
     *
     * @return int
     */
    public function getActionCode(): int
    {
        return (int) $this->data['actionCode'];
    }

    /**
     * Description of the action code
     *
     * @return string
     */
    public function getActionCodeDescription(): ?string
    {
        return $this->data['actionCodeDescription'];
    }

    /**
     * Amount
     *
     * @return int
     */
    public function getAmount(): int
    {
        return (int) $this->data['amount'];
    }

    /**
     * Currency in ISO 4217
     *
     * @return int
     */
    public function getCurrency(): int
    {
        return (int) $this->data['currency'];
    }

    /**
     * Order creation date (timestamp)
     *
     * @return string
     */
    public function getDate(): ?string
    {
        return $this->data['date'];
    }

    /**
     * Order description
     *
     * @return string
     */
    public function getOrderDescription(): ?string
    {
        return $this->getDataValueOrNull('orderDescription');
    }

    /**
     * Client's IP-address
     *
     * @return string
     */
    public function getIp(): ?string
    {
        return $this->data['ip'];
    }

    /**
     * User's operation system
     * 
     * @return null|string
     */
    public function getOs(): ?string
    {
        return $this->getMerchantOrderParam('browser_os_param');
    }

    /**
     * Client's browser
     * 
     * @return null|string
     */
    public function getBrowserName(): ?string
    {
        return $this->getMerchantOrderParam('browser_name_param');
    }

    /**
     * Client's browser version
     * 
     * @return null|string
     */
    public function getBrowserVersion(): ?string
    {
        return $this->getMerchantOrderParam('browser_version_param');
    }

    /**
     * Client's browser language
     * 
     * @return null|string
     */
    public function getBrowserLanguage(): ?string
    {
        return $this->getMerchantOrderParam('browser_language_param');
    }

    /**
     * Client's user agent
     * 
     * @return null|string
     */
    public function getUserAgent(): ?string
    {
        return $this->getMerchantOrderParam('user_agent');
    }

    /**
     * Card expiration date
     * 
     * @return string
     */
    public function getCardExpiration(): ?string
    {
        return $this->data['cardAuthInfo']['expiration'];
    }

    /**
     * Card holder
     * 
     * @return string
     */
    public function getCardHolder(): ?string
    {
        return $this->data['cardAuthInfo']['cardholderName'];
    }

    /**
     * Card number
     * 
     * @return string
     */
    public function getCardPan(): ?string
    {
        return $this->data['cardAuthInfo']['pan'];
    }

    /**
     * Bank name
     * 
     * @return string
     */
    public function getBankName(): ?string
    {
        return $this->data['bankInfo']['bankName'];
    }

    /**
     * Bank country code
     * 
     * @return string
     */
    public function getBankCountryCode(): ?string
    {
        return $this->data['bankInfo']['bankCountryCode'];
    }

    /**
     * Bank country name
     * 
     * @return string
     */
    public function getBankCountryName(): ?string
    {
        return $this->data['bankInfo']['bankCountryName'];
    }

    /**
     * Client id (if used)
     *
     * @return string
     */
    public function getClientId(): ?string
    {
        return $this->getDataValueOrNull('clientId');
    }

    /**
     * Binding id (if used)
     *
     * @return string
     */
    public function getBindingId(): ?string
    {
        return $this->getDataValueOrNull('bindingId');
    }
}
