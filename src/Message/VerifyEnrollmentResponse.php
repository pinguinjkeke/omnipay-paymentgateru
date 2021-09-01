<?php

namespace Omnipay\RbsUat\Message;

class VerifyEnrollmentResponse extends AbstractCurlResponse
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
     * Response Message
     *
     * @return null|string A response message from the payment gateway
     */
    public function getMessage(): ?string
    {
        return $this->data['errorMessage'];
    }

    /**
     * Is card enrolled to 3DS?
     *
     * @return bool
     */
    public function getEnrolled(): bool
    {
        return $this->data['enrolled'] === 'Y';
    }

    /**
     * Emitter bank name
     *
     * @return string
     */
    public function getEmitterName(): ?string
    {
        return $this->data['emitterName'];
    }

    /**
     * Emitter bank country code
     *
     * @return string
     */
    public function getEmitterCountryCode(): ?string
    {
        return $this->data['emitterCountryCode'];
    }
}
