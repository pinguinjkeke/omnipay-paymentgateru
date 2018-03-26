<?php

namespace Omnipay\PaymentgateRu\Message;

class CardExtendBindingRequest extends AbstractCurlRequest
{
    /**
     * Get binding id
     *
     * @return string
     */
    public function getBindingId(): ?string
    {
        return $this->getParameter('bindingId');
    }

    /**
     * Set binding id
     *
     * @param string $bindingId
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setBindingId($bindingId): self
    {
        return $this->setParameter('bindingId', $bindingId);
    }

    /**
     * Get new expiry in YYYYMM format
     *
     * @return string
     */
    public function getNewExpiry(): ?string
    {
        return $this->getParameter('newExpiry');
    }

    /**
     * Set new expiry in YYYYMM format
     *
     * @param string $newExpiry
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setNewExpiry($newExpiry): self
    {
        return $this->setParameter('newExpiry', $newExpiry);
    }

    /**
     * Method name from bank API
     *
     * @return string
     */
    protected function getMethod(): string
    {
        return 'rest/extendBinding.do';
    }

    /**
     * Response class name. Method will be ignored if class name passed to constructor third parameter
     *
     * @return string
     */
    public function getResponseClass(): string
    {
        return 'CardExtendBindingResponse';
    }

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate('bindingId', 'newExpiry');

        $data = [
            'bindingId' => $this->getBindingId(),
            'newExpiry' => $this->getNewExpiry(),
        ];

        if ($language = $this->getLanguage()) {
            $data['language'] = $language;
        }

        return $data;
    }
}
