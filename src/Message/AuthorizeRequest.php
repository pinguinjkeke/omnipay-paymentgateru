<?php

namespace Omnipay\RbsUat\Message;

use Omnipay\RbsUat\OrderBundle\OrderBundle;

class AuthorizeRequest extends AbstractCurlRequest
{
    // Available features
    public const FEATURES_AUTO_PAYMENT = 'AUTO_PAYMENT';
    public const FEATURES_VERIFY = 'VERIFY';

    /**
     * Order Bundle.
     *
     * @var OrderBundle
     */
    protected $orderBundle;

    /**
     * Get page view
     *
     * @return string|null
     */
    public function getPageView(): ?string
    {
        return $this->getParameter('pageView');
    }

    /**
     * Defaults are DESKTOP or MOBILE if you implemented it in your payment page template.
     *
     * @param string $pageView
     * @return \Omnipay\Common\Message\AbstractRequest|$this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setPageView($pageView): self
    {
        return $this->setParameter('pageView', $pageView);
    }

    /**
     * Get session timeout in seconds
     *
     * @return int|null
     */
    public function getSessionTimeoutSecs(): ?int
    {
        return $this->getParameter('sessionTimeoutSecs');
    }

    /**
     * Set session timeout in seconds
     *
     * @param int $sessionTimeoutSecs
     * @return \Omnipay\Common\Message\AbstractRequest|$this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setSessionTimeoutSecs($sessionTimeoutSecs): self
    {
        return $this->setParameter('sessionTimeoutSecs', $sessionTimeoutSecs);
    }

    /**
     * Get id of previously created binding. Use only if you work with bindings.
     *
     * @return string|null
     */
    public function getBindingId(): ?string
    {
        return $this->getParameter('bindingId');
    }

    /**
     * Set id of previously created binding. Use only if you work with bindings.
     *
     * @param string $bindingId
     * @return \Omnipay\Common\Message\AbstractRequest|$this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setBindingId($bindingId): self
    {
        return $this->setParameter('bindingId', $bindingId);
    }

    /**
     * Get features (AUTO_PAYMENT or VERIFY)
     *
     * @link https://pay.alfabank.ru/ecommerce/_build/html/auto_payments.html#auto-payment-label
     * @return string|null
     */
    public function getFeatures(): ?string
    {
        return $this->getParameter('features');
    }

    /**
     * Set features (AUTO_PAYMENT or VERIFY)
     *
     * @param string $features
     * @return \Omnipay\Common\Message\AbstractRequest|$this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setFeatures($features): self
    {
        return $this->setParameter('features', $features);
    }

    /**
     * Get order expiration date in yyyy-MM-ddTHH:mm:ss
     *
     * @return string|null
     */
    public function getExpirationDate(): ?string
    {
        return $this->getParameter('expirationDate');
    }

    /**
     * Set order expiration date in yyyy-MM-ddTHH:mm:ss
     *
     * @param string $expirationDate
     * @return \Omnipay\Common\Message\AbstractRequest|$this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setExpirationDate($expirationDate): self
    {
        return $this->setParameter('expirationDate', $expirationDate);
    }

    /**
     * Get fail payment url
     *
     * @return string|null
     */
    public function getFailUrl(): ?string
    {
        return $this->getParameter('failUrl');
    }

    /**
     * Set fail payment url
     *
     * @param string $failUrl
     * @return \Omnipay\Common\Message\AbstractRequest|$this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setFailUrl($failUrl): self
    {
        return $this->setParameter('failUrl', $failUrl);
    }

    /**
     * Get client id for bindings
     *
     * @return string|null
     */
    public function getClientId(): ?string
    {
        return $this->getParameter('clientId');
    }

    /**
     * Set client id for bindings
     *
     * @param string $clientId
     * @return \Omnipay\Common\Message\AbstractRequest|$this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setClientId($clientId): self
    {
        return $this->setParameter('clientId', $clientId);
    }

    /**
     * Additional merchant login if you using one.
     *
     * @return string|null
     */
    public function getMerchantLogin(): ?string
    {
        return $this->getParameter('merchantLogin');
    }

    /**
     * Additional merchant login if you using one.
     *
     * @param string $merchantLogin
     * @return \Omnipay\Common\Message\AbstractRequest|$this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setMerchantLogin($merchantLogin): self
    {
        return $this->setParameter('merchantLogin', $merchantLogin);
    }

    /**
     * Is order two stepped?
     *
     * @return bool|null
     */
    public function getTwoStep(): ?bool
    {
        return $this->getParameter('two_stage');
    }

    /**
     * Set two step order authentication
     *
     * @param bool $twoStage
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setTwoStep($twoStage): self
    {
        return $this->setParameter('two_stage', $twoStage);
    }

    /**
     * Used tax system
     *
     * @return int|null
     */
    public function getTaxSystem(): ?int
    {
        return $this->getParameter('taxSystem');
    }

    /**
     * Set tax system
     *
     * @param $taxSystem
     * @return \Omnipay\Common\Message\AbstractRequest|$this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setTaxSystem($taxSystem): self
    {
        return $this->setParameter('taxSystem', $taxSystem);
    }

    /**
     * Method name from bank API
     *
     * @return string
     */
    protected function getMethod(): string
    {
        return $this->getTwoStep() ? 'rest/registerPreAuth.do' : 'rest/register.do';
    }

    /**
     * Response class name. Method will be ignored if class name passed to constructor third parameter
     *
     * @return string
     */
    public function getResponseClass(): string
    {
        return 'AuthorizeResponse';
    }

    /**
     * Set OrderBundle.
     *
     * @param OrderBundle $bundle
     * @return $this
     */
    public function setOrderBundle(OrderBundle $bundle): self
    {
        $this->orderBundle = $bundle;

        return $this;
    }

    /**
     * Order Bundle.
     *
     * @return OrderBundle|null
     */
    public function getOrderBundle(): ?OrderBundle
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
    public function getData(): array
    {
        $this->validate('orderNumber', 'amount', 'returnUrl');
        
        $data = [
            'orderNumber' => $this->getOrderNumber(),
            'amount' => $this->getAmount(),
            'returnUrl' => $this->getReturnUrl(),
        ];

        $extraParameters = [
            'currency', 'description', 'language', 'pageView', 'sessionTimeoutSecs', 'features',
            'bindingId', 'expirationDate', 'failUrl', 'clientId', 'merchantLogin', 'taxSystem',
        ];

        foreach ($extraParameters as $parameter) {
            $getter = 'get' . ucfirst($parameter);

            if (method_exists($this, $getter)) {
                $value = $this->{$getter}();

                if ($value !== null) {
                    $data[$parameter] = $value;
                }
            }
        }

        if ($this->orderBundle) {
            $data['orderBundle'] = json_encode($this->orderBundle->toArray());
        }

        return $data;
    }
}
