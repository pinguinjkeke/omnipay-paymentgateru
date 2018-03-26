<?php

namespace Omnipay\PaymentgateRu\Message;

class DepositRequest extends AbstractCurlRequest
{
    /**
     * Get order id
     *
     * @return string
     */
    public function getOrderId(): ?string
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
    public function setOrderId($orderId): self
    {
        return $this->setParameter('orderId', $orderId);
    }

    /**
     * Method name from bank API
     *
     * @return string
     */
    protected function getMethod(): string
    {
        return 'rest/deposit.do';
    }

    /**
     * Response class name. Method will be ignored if class name passed to constructor third parameter
     *
     * @return string
     */
    public function getResponseClass(): string
    {
        return 'DepositResponse';
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
        $this->validate('orderId', 'amount');

        $data = [
            'orderId' => $this->getOrderId(),
            'amount' => $this->getAmount(),
        ];

        if ($language = $this->getLanguage()) {
            $data['language'] = $language;
        }

        return $data;
    }
}
