<?php

namespace Omnipay\PaymentgateRu\Message;

class GetClientBindingsRequest extends AbstractCurlRequest
{
    /**
     * Get client id
     * 
     * @return null|string
     */
    public function getClientId(): ?string
    {
        return $this->getParameter('clientId');
    }

    /**
     * Set client id
     *
     * @param int|string $clientId
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setClientId($clientId): self
    {
        return $this->setParameter('clientId', $clientId);
    }

    /**
     * Method name from bank API
     *
     * @return string
     */
    protected function getMethod(): string
    {
        return 'rest/getBindings.do';
    }

    /**
     * Response class name. Method will be ignored if class name passed to constructor third parameter
     *
     * @return string
     */
    public function getResponseClass(): string
    {
        return 'GetClientBindingsResponse';
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
        $this->validate('clientId');
        
        return [
            'clientId' => $this->getClientId(),
        ];
    }
}
