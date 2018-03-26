<?php

namespace Omnipay\PaymentgateRu\Message;

class CardUnbindRequest extends AbstractCurlRequest
{
    /**
     * Get binding id
     * 
     * @return string|null
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
     * Method name from bank API
     *
     * @return string
     */
    protected function getMethod(): string
    {
        return 'rest/unBindCard.do';
    }

    /**
     * Response class name. Method will be ignored if class name passed to constructor third parameter
     *
     * @return string
     */
    public function getResponseClass(): string
    {
        return 'CardUnbindResponse';
    }

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return array
     */
    public function getData(): array
    {
        return [
            'bindingId' => $this->getBindingId(),
        ];
    }
}
