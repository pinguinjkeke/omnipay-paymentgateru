<?php

namespace Omnipay\PaymentgateRu\Message;

use Omnipay\PaymentgateRu\OrderBundle\OrderBundle;

class AuthorizeRequest extends AbstractCurlRequest
{
    /**
     * Order Bundle.
     *
     * @var OrderBundle
     */
    protected $orderBundle;

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
     * @return $this
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
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setSessionTimeoutSecs($sessionTimeoutSecs)
    {
        return $this->setParameter('sessionTimeoutSecs', $sessionTimeoutSecs);
    }

    /**
     * Get id of previously created binding. Use only if you work with bindings.
     *
     * @return string
     */
    public function getBindingId()
    {
        return $this->getParameter('bindingId');
    }

    /**
     * Set id of previously created binding. Use only if you work with bindings.
     *
     * @param string $bindingId
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setBindingId($bindingId)
    {
        return $this->setParameter('bindingId', $bindingId);
    }

    /**
     * Get order expiration date in yyyy-MM-ddTHH:mm:ss
     *
     * @return string
     */
    public function getExpirationDate()
    {
        return $this->getParameter('expirationDate');
    }

    /**
     * Set order expiration date in yyyy-MM-ddTHH:mm:ss
     *
     * @param string $expirationDate
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setExpirationDate($expirationDate)
    {
        return $this->setParameter('expirationDate', $expirationDate);
    }

    /**
     * Get fail payment url
     *
     * @return string
     */
    public function getFailUrl()
    {
        return $this->getParameter('failUrl');
    }

    /**
     * Set fail payment url
     *
     * @param string $failUrl
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setFailUrl($failUrl)
    {
        return $this->setParameter('failUrl', $failUrl);
    }

    /**
     * Get client id for bindings
     *
     * @return string
     */
    public function getClientId()
    {
        return $this->getParameter('clientId');
    }

    /**
     * Set client id for bindings
     *
     * @param string $clientId
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setClientId($clientId)
    {
        return $this->setParameter('clientId', $clientId);
    }

    /**
     * Additional merchant login if you using one.
     *
     * @return string
     */
    public function getMerchantLogin()
    {
        return $this->getParameter('merchantLogin');
    }

    /**
     * Additional merchant login if you using one.
     *
     * @param string $merchantLogin
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setMerchantLogin($merchantLogin)
    {
        return $this->setParameter('merchantLogin', $merchantLogin);
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
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setTwoStep($twoStage)
    {
        return $this->setParameter('two_stage', $twoStage);
    }

    /**
     * Used tax system
     *
     * @return int
     */
    public function getTaxSystem()
    {
        return $this->getParameter('tax_system');
    }

    /**
     * Set tax system
     *
     * @param $taxSystem
     * @return \Omnipay\Common\Message\AbstractRequest
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setTaxSystem($taxSystem)
    {
        return $this->setParameter('tax_system', $taxSystem);
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
     * Set OrderBundle.
     *
     * @param OrderBundle $bundle
     * @return $this
     */
    public function setOrderBundle(OrderBundle $bundle)
    {
        $this->orderBundle = $bundle;

        return $this;
    }

    /**
     * Order Bundle.
     *
     * @return OrderBundle
     */
    public function getOrderBundle()
    {
        return $this->orderBundle;
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

        $extraParameters = array(
            'currency', 'description', 'language', 'pageView', 'sessionTimeoutSecs',
            'bindingId', 'expirationDate', 'failUrl', 'clientId', 'merchantLogin', 'taxSystem'
        );

        foreach ($extraParameters as $parameter) {
            $getter = 'get' . ucfirst($parameter);

            if (method_exists($this, $getter) && ($value = $this->{$getter}())) {
                $data[$parameter] = $value;
            }
        }

        if ($this->orderBundle) {
            $data['orderBundle'] = $this->orderBundle->toArray();
        }

        return $data;
    }
}
