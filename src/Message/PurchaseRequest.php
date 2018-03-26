<?php

namespace Omnipay\PaymentgateRu\Message;

class PurchaseRequest extends AbstractCurlRequest
{
    /**
     * Get order number
     * 
     * @return string|null
     */
    public function getMdOrder(): ?string
    {
        return $this->getParameter('mdOrder');
    }

    /**
     * Set order number
     *
     * @param string $mdOrder
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setMdOrder($mdOrder): self
    {
        return $this->setParameter('mdOrder', $mdOrder);
    }

    /**
     * Get binding id
     * 
     * @return string
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
     * Get client's IP-address
     * 
     * @return string
     */
    public function getIp(): ?string
    {
        return $this->getParameter('ip');
    }

    /**
     * Set client's IP-address
     *
     * @param string $ip
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setIp($ip): self
    {
        return $this->setParameter('ip', $ip);
    }

    /**
     * Get CVC code (if needed)
     * 
     * @return int
     */
    public function getCvc(): ?int
    {
        return $this->getParameter('cvc');
    }

    /**
     * Set CVC code (if needed)
     *
     * @param int $cvc
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setCvc($cvc): self
    {
        return $this->setParameter('cvc', $cvc);
    }

    /**
     * Get user's email address
     * 
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->getParameter('email');
    }

    /**
     * Set user's email address
     *
     * @param string $email
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setEmail($email): self
    {
        return $this->setParameter('email', $email);
    }

    /**
     * Method name from bank API
     *
     * @return string
     */
    protected function getMethod(): string
    {
        return 'rest/paymentOrderBinding.do';
    }

    /**
     * Response class name. Method will be ignored if class name passed to constructor third parameter
     *
     * @return string
     */
    public function getResponseClass(): string
    {
        return 'PurchaseResponse';
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
        $this->validate('mdOrder', 'bindingId', 'ip');

        $data = [
            'mdOrder' => $this->getMdOrder(),
            'bindingId' => $this->getBindingId(),
            'ip' => $this->getIp(),
        ];
        
        if ($language = $this->getLanguage()) {
            $data['language'] = $language;
        }
        
        if ($cvc = $this->getCvc()) {
            $data['cvc'] = $cvc;
        }
        
        if ($email = $this->getEmail()) {
            $data['email'] = $email;
        }
        
        return $data;
    }
}
