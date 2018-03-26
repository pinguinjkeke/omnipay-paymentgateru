<?php

namespace Omnipay\PaymentgateRu\Message;

class AddParamsRequest extends AbstractCurlRequest
{
    /**
     * Get order id
     *
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->getParameter('orderId');
    }

    /**
     * Set order id
     *
     * @param string $orderId
     * @return \Omnipay\Common\Message\AbstractRequest|$this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setOrderId($orderId): self
    {
        return $this->setParameter('orderId', $orderId);
    }

    /**
     * Get order additional parameters
     *
     * @return array
     */
    public function getParams(): array
    {
        return $this->getParameter('params');
    }

    /**
     * Set order additional parameters
     *
     * @param array $params
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\PaymentgateRu\Message\AddParamsRequest
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setParams($params): self
    {
        return $this->setParameter('params', $params);
    }

    /**
     * Add order parameter
     *
     * @param string $key
     * @param mixed $value
     * @return \Omnipay\Common\Message\AbstractRequest|$this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function addParam($key, $value): self
    {
        $params = $this->getParams();
        $params[$key] = $value;
        
        return $this->setParameter('params', $params);
    }

    /**
     * Method name from bank API
     *
     * @return string
     */
    protected function getMethod(): string
    {
        return 'rest/addParams.do';
    }

    /**
     * Response class name. Method will be ignored if class name passed to constructor third parameter
     *
     * @return string
     */
    public function getResponseClass(): string
    {
        return 'AddParamsResponse';
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
        $this->validate('orderId', 'params');
        
        $data = [
            'orderId' => $this->getOrderId(),
            'params' => json_encode($this->getParams()),
        ];
        
        if ($language = $this->getLanguage()) {
            $data['language'] = $language;
        }
        
        return $data;
    }
}
