<?php

namespace Omnipay\PaymentgateRu\Message;

class GetClientBindingsRequest extends AbstractCurlRequest
{
    /**
     * Get client id
     * 
     * @return int|string
     */
    public function getClientId()
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
    public function setClientId($clientId)
    {
        return $this->setParameter('clientId', $clientId);
    }
    
    /**
     * Method name from bank API
     *
     * @return string
     */
    protected function getMethod()
    {
        return 'getBindings.do';
    }

    /**
     * Response class name. Method will be ignored if class name passed to constructor third parameter
     *
     * @return string
     */
    public function getResponseClass()
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
    public function getData()
    {
        $this->validate('clientId');
        
        return array(
            'clientId' => $this->getClientId()
        );
    }
}
