<?php

namespace Omnipay\PaymentgateRu\Message;

class AuthorizeRequest extends AbstractCurlRequest
{
    /**
     * Is order two stepped?
     *
     * @return boolean
     */
    public function getTwoStep()
    {
        return $this->getParameter('two_stage');
    }

    /**
     * Set two step order authentication
     *
     * @param boolean $twoStage
     * @return \Omnipay\Common\Message\AbstractRequest
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setTwoStep($twoStage)
    {
        return $this->setParameter('two_stage', $twoStage);
    }

    /**
     * Validates and returns the formatted amount.
     * Paymentgate requires to send amount in kopeck instead of just rubles
     *
     * @return int
     */
    public function getAmount()
    {
        return (int) $this->getParameter('amount');
    }

    /**
     * Method name from bank API
     *
     * @return string
     */
    protected function getMethod()
    {
        return $this->getTwoStep() ? 'registerPreAuth.do' : 'register.do';
    }

    /**
     * Response class name
     *
     * @return string
     */
    protected function getResponseClass()
    {
        return 'AuthorizeResponse';
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
        $this->validate();
        
        return array(
            'orderNumber' => $this->getOrderNumber(),
            'amount' => $this->getAmount(),
            'returnUrl' => $this->getReturnUrl()
        );
    }
}
