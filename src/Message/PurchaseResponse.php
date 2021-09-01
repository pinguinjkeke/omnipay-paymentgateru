<?php

namespace Omnipay\RbsUat\Message;

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
        return $this->data[$parameter] ?? null;
    }

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
     * Does the response require a redirect?
     *
     * @return bool
     */
    public function isRedirect(): bool
    {
        return array_key_exists('redirect', $this->data);
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
     * Redirect url
     *
     * @return string|null
     */
    public function getRedirectUrl(): ?string
    {
        return $this->getDataValueOrNull('redirect');
    }

    /**
     * Payment info
     *
     * @return string|null
     */
    public function getInfo(): ?string
    {
        return $this->getDataValueOrNull('info');
    }

    /**
     * 3DS url
     *
     * @return string|null
     */
    public function getAcsUrl(): ?string
    {
        return $this->getDataValueOrNull('acsUrl');
    }

    /**
     * 3DS payment authentication request
     *
     * @return string|null
     */
    public function getPaReq(): ?string
    {
        return $this->getDataValueOrNull('paReq');
    }

    /**
     * 3DS back-url
     *
     * @return string|null
     */
    public function getTermUrl(): ?string
    {
        return $this->getDataValueOrNull('termUrl');
    }
}
