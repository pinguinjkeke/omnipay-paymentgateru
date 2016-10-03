<?php

namespace Omnipay\PaymentgateRu\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class StatusExtendedRequest extends AbstractCurlRequest
{
    /**
     * Get order id
     *
     * @return string
     */
    public function getOrderId()
    {
        return $this->getParameter('orderId');
    }

    /**
     * Set order id
     *
     * @param string $orderId
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setOrderId($orderId)
    {
        return $this->setParameter('orderId', $orderId);
    }

    /**
     * Method name from bank API
     *
     * @return string
     */
    protected function getMethod()
    {
        return 'getOrderStatusExtended.do';
    }

    /**
     * Response class name. Method will be ignored if class name passed to constructor third parameter
     *
     * @return string
     */
    public function getResponseClass()
    {
        return 'StatusExtendedResponse';
    }

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $data = array();
        
        if ($order = $this->getOrderId()) {
            $data['orderId'] = $order;
        } elseif ($order = $this->getOrderNumber()) {
            $data['orderNumber'] = $order;
        } else {
            throw new InvalidRequestException('No orderId or orderNumber provided');
        }

        if ($language = $this->getLanguage()) {
            $data['language'] = $language;
        }

        return $data;
    }
}
