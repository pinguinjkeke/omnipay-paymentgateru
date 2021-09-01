<?php

namespace Omnipay\RbsUat\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

abstract class AbstractCurlResponse extends AbstractResponse
{
    /**
     * Constructor
     *
     * @param RequestInterface $request the initiating request.
     * @param mixed $data
     */
    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, json_decode($data, true));
    }

    /**
     * Is the response successful?
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return !array_key_exists('errorCode', $this->data);
    }

    /**
     * Response code
     *
     * @return null|string A response code from the payment gateway
     */
    public function getCode()
    {
        return $this->isSuccessful() ? null : $this->data['errorCode'];
    }

    /**
     * Response Message
     *
     * @return null|string A response message from the payment gateway
     */
    public function getMessage(): ?string
    {
        return $this->isSuccessful() ? null : $this->data['errorMessage'];
    }
}
