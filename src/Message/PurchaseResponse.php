<?php

namespace Omnipay\PaymentgateRu\Message;

class PurchaseResponse extends AbstractCurlResponse
{
    /**
     * Return data value or null
     *
     * @param string $parameter
     * @return mixed
     */
    protected function getDataValueOrNull($parameter)
    {
        return array_key_exists($parameter, $this->data) ? $this->data[$parameter] : null;
    }
    
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
     * Does the response require a redirect?
     *
     * @return boolean
     */
    public function isRedirect()
    {
        return array_key_exists('redirect', $this->data);
    }

    /**
     * Response code
     *
     * @return int A response code from the payment gateway
     */
    public function getCode()
    {
        return (int) $this->data['errorCode'];
    }

    /**
     * Redirect url
     * 
     * @return string|null
     */
    public function getRedirectUrl()
    {
        return $this->getDataValueOrNull('redirect'); 
    }

    /**
     * Payment info
     * 
     * @return string|null
     */
    public function getInfo()
    {
        return $this->getDataValueOrNull('info');
    }

    /**
     * 3DS url
     * 
     * @return string|null
     */
    public function getAcsUrl()
    {
        return $this->getDataValueOrNull('acsUrl');
    }

    /**
     * 3DS payment authentication request
     * 
     * @return string|null
     */
    public function getPaReq()
    {
        return $this->getDataValueOrNull('paReq');
    }

    /**
     * 3DS back-url
     * 
     * @return string|null
     */
    public function getTermUrl()
    {
        return $this->getDataValueOrNull('termUrl');
    }
}
