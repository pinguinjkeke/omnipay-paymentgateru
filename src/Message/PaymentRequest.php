<?php

namespace Omnipay\PaymentgateRu\Message;

class PaymentRequest extends AbstractCurlRequest
{
    /**
     * Method name from bank API
     *
     * @return string
     */
    protected function getMethod()
    {
        return 'payment.do';
    }

    /**
     * Response class name. Method will be ignored if class name passed to constructor third parameter
     *
     * @return string
     */
    public function getResponseClass()
    {
        return 'PaymentResponse';
    }

    /**
     * Get merchant name
     *
     * @return string
     */
    public function getMerchant()
    {
        return $this->getParameter('merchant');
    }

    /**
     * Get merchant name
     *
     * @param string $merchant
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setMerchant($merchant)
    {
        return $this->setParameter('merchant', $merchant);
    }

    /**
     * Get Payment token
     *
     * @return array|string
     */
    public function getPaymentToken()
    {
        return $this->getParameter('paymentToken');
    }

    /**
     * Set Payment token
     *
     * @param array|string $paymentToken
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setPaymentToken($paymentToken)
    {
        return $this->setParameter('paymentToken', $paymentToken);
    }

    /**
     * Additional parameters.
     *
     * @return array|null
     */
    public function getAdditionalParameters()
    {
        return $this->getParameter('additionalParameters');
    }

    /**
     * Set array of additional parameters.
     *
     * @param array $additionalParameters
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setAdditionalParameters(array $additionalParameters)
    {
        return $this->setParameter('additionalParameters', $additionalParameters);
    }

    /**
     * Get client id.
     *
     * @return int|null
     */
    public function getClientId()
    {
        return $this->getParameter('clientId');
    }

    /**
     * Set client id to create binding.
     *
     * @param int $clientId
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setClientId($clientId)
    {
        return $this->setParameter('clientId', $clientId);
    }

    /**
     * Is pre auth required?
     *
     * @return bool|null
     */
    public function getPreAuth()
    {
        return $this->getParameter('preAuth');
    }

    /**
     * Set is pre auth required.
     *
     * @param bool $preAuth
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setPreAuth($preAuth)
    {
        return $this->setParameter('preAuth', (bool) $preAuth);
    }

    /**
     * Get Request headers
     *
     * @return array
     */
    public function getHeaders()
    {
        return array_merge(
            parent::getHeaders(),
            array('Content-Type' => 'application/json')
        );
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
        $this->validate('merchant', 'orderNumber', 'paymentToken');

        $paymentToken = $this->getPaymentToken();

        if (is_array($paymentToken)) {
            $paymentToken = json_encode($paymentToken);
        }

        $data = array(
            'merchant' => $this->getMerchant(),
            'orderNumber' => $this->getOrderNumber(),
            'paymentToken' => base64_encode($paymentToken)
        );

        foreach (array('description', 'language', 'additionalParameters', 'clientId', 'preAuth') as $parameter) {
            $method = 'get' . ucfirst($parameter);

            if (method_exists($this, $method)) {
                $value = $this->{$method}();

                if ($value) {
                    $data[$parameter] = $value;
                }
            }
        }

        return $data;
    }
}
