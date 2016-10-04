<?php

namespace Omnipay\PaymentgateRu\Message;

class VerifyEnrollmentResponse extends AbstractCurlResponse
{
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
     * Response code
     *
     * @return null|string A response code from the payment gateway
     */
    public function getCode()
    {
        return (int) $this->data['errorCode'];
    }

    /**
     * Response Message
     *
     * @return null|string A response message from the payment gateway
     */
    public function getMessage()
    {
        return $this->data['errorMessage'];
    }

    /**
     * Is card enrolled to 3DS?
     * 
     * @return boolean
     */
    public function getEnrolled()
    {
        return $this->data['enrolled'] === 'Y';
    }

    /**
     * Emitter bank name
     * 
     * @return string
     */
    public function getEmitterName()
    {
        return $this->data['emitterName'];
    }

    /**
     * Emitter bank country code
     *
     * @return string
     */
    public function getEmitterCountryCode()
    {
        return $this->data['emitterCountryCode'];
    }
}
