<?php

namespace Omnipay\PaymentgateRu\Message;

class AuthorizeRequest extends AbstractCurlRequest
{
    /**
     * Get language (ISO 639-1)
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->getParameter('language');
    }

    /**
     * Set language (ISO 639-1)
     *
     * @param string $language
     * @return \Omnipay\Common\Message\AbstractRequest
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setLanguage($language)
    {
        return $this->setParameter('language', $language);
    }

    /**
     * Get page view
     *
     * @return string
     */
    public function getPageView()
    {
        return $this->getParameter('pageView');
    }

    /**
     * Defaults are DESKTOP or MOBILE if you implemented it in your payment page template.
     *
     * @param string $pageView
     * @return \Omnipay\Common\Message\AbstractRequest
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setPageView($pageView)
    {
        return $this->setParameter('pageView', $pageView);
    }

    /**
     * Get session timeout in seconds
     *
     * @return int
     */
    public function getSessionTimeoutSecs()
    {
        return $this->getParameter('sessionTimeoutSecs');
    }

    /**
     * Set session timeout in seconds
     *
     * @param int $sessionTimeoutSecs
     * @return \Omnipay\Common\Message\AbstractRequest
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setSessionTimeoutSecs($sessionTimeoutSecs)
    {
        return $this->setParameter('sessionTimeoutSecs', $sessionTimeoutSecs);
    }

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
     * Response class name. Method will be ignored if class name passed to constructor third parameter
     *
     * @return string
     */
    public function getResponseClass()
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
        $this->validate('orderNumber', 'amount', 'returnUrl');
        
        $data = array(
            'orderNumber' => $this->getOrderNumber(),
            'amount' => $this->getAmount(),
            'returnUrl' => $this->getReturnUrl()
        );

        if ($currency = $this->getCurrency()) {
            $data['currency'] = $this->getCurrency();
        }

        if ($language = $this->getLanguage()) {
            $data['language'] = $language;
        }

        if ($pageView = $this->getPageView()) {
            $data['pageView'] = $pageView;
        }

        if ($sessionTimeoutSecs = $this->getSessionTimeoutSecs()) {
            $data['sessionTimeoutSecs'] = $sessionTimeoutSecs;
        }

        return $data;
    }
}
