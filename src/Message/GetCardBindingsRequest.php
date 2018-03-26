<?php

namespace Omnipay\PaymentgateRu\Message;

use InvalidArgumentException;

class GetCardBindingsRequest extends AbstractCurlRequest
{
    /**
     * Get card pan
     * 
     * @return string
     */
    public function getPan(): ?string
    {
        return $this->getParameter('pan');
    }

    /**
     * Set card pan
     *
     * @param string $pan
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setPan($pan): self
    {
        return $this->setParameter('pan', $pan);
    }

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
     * Get show expired bindings
     * 
     * @return string
     */
    public function getShowExpired(): ?string
    {
        return $this->getParameter('showExpired');
    }

    /**
     * Set show expired bindings
     *
     * @param string $showExpired
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setShowExpired($showExpired): self
    {
        return $this->setParameter('showExpired', $showExpired);
    }

    /**
     * Method name from bank API
     *
     * @return string
     */
    protected function getMethod(): string
    {
        return 'rest/getBindingsByCardOrId.do';
    }

    /**
     * Response class name. Method will be ignored if class name passed to constructor third parameter
     *
     * @return string
     */
    public function getResponseClass(): string
    {
        return 'GetCardBindingsResponse';
    }

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return array
     * @throws \InvalidArgumentException
     */
    public function getData(): array
    {
        $data = [];
        
        if ($pan = $this->getPan()) {
            $data['pan'] = $pan;
        }
        
        if ($bindingId = $this->getBindingId()) {
            $data['bindingId'] = $bindingId;
        }

        if (\count($data) === 0) {
            throw new InvalidArgumentException('You must provide pan or bindingId to data');
        }
        
        if ($showExpired = $this->getShowExpired()) {
            $data['showExpired'] = ($showExpired === 'true') ? 'true' : 'false';
        }
        
        return $data;
    }
}
