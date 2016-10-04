<?php

namespace Omnipay\PaymentgateRu\Message;

class VerifyEnrollmentRequest extends AbstractCurlRequest
{
    /**
     * Get pan (credit card number)
     * 
     * @return string
     */
    public function getPan()
    {
        return $this->getParameter('pan');
    }

    /**
     * Set pan (credit card number)
     *
     * @param string $pan
     * @return \Omnipay\Common\Message\AbstractRequest
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setPan($pan)
    {
        return $this->setParameter('pan', $pan);
    }
    
    /**
     * Method name from bank API
     *
     * @return string
     */
    protected function getMethod()
    {
        return 'verifyEnrollment.do';
    }

    /**
     * Response class name. Method will be ignored if class name passed to constructor third parameter
     *
     * @return string
     */
    public function getResponseClass()
    {
        return 'VerifyEnrollmentResponse';
    }

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return array
     */
    public function getData()
    {
        return array(
            'pan' => $this->getPan()
        );
    }
}
