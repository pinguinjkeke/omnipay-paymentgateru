<?php

namespace Omnipay\PaymentgateRu\Message;

use Guzzle\Http\ClientInterface;
use Guzzle\Http\Exception\ServerErrorResponseException;
use Omnipay\Common\Exception\RuntimeException;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

abstract class AbstractCurlRequest extends AbstractRequest
{
    /**
     * Response class name
     *
     * @var string
     */
    protected $responseClass;

    /**
     * Method name from bank API
     *
     * @return string
     */
    abstract protected function getMethod();

    /**
     * Response class name. Method will be ignored if class name passed to constructor third parameter
     *
     * @return string
     */
    abstract public function getResponseClass();

    /**
     * Create a new Request
     *
     * @param ClientInterface $httpClient A Guzzle client to make API calls with
     * @param HttpRequest $httpRequest A Symfony HTTP request object
     * @param null|string Response class name (overrides getResponseClass method). Created for test purposes
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function __construct(ClientInterface $httpClient, HttpRequest $httpRequest, $responseClass = null)
    {
        parent::__construct($httpClient, $httpRequest);

        $this->responseClass = '\\Omnipay\\PaymentgateRu\\Message\\' . ($responseClass ?: $this->getResponseClass());

        if (!class_exists($this->responseClass)) {
            throw new RuntimeException("Response class \"{$this->responseClass}\" not exists");
        }
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
     * Get gateway user name
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->getParameter('userName');
    }

    /**
     * Set gateway user name
     *
     * @param string $userName
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setUserName($userName)
    {
        return $this->setParameter('userName', $userName);
    }

    /**
     * Get gateway password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    /**
     * Set gateway password
     *
     * @param string $password
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setPassword($password)
    {
        return $this->setParameter('password', $password);
    }

    /**
     * Get order number
     *
     * @return int|string
     */
    public function getOrderNumber()
    {
        return $this->getParameter('orderNumber');
    }

    /**
     * Set order number
     *
     * @param int|string $orderNumber
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setOrderNumber($orderNumber)
    {
        return $this->setParameter('orderNumber', $orderNumber);
    }

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
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setLanguage($language)
    {
        return $this->setParameter('language', $language);
    }

    /**
     * Get endpoint URL
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->getParameter('endpoint');
    }

    /**
     * Set endpoint URL
     *
     * @param string $endpoint
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setEndpoint($endpoint)
    {
        return $this->setParameter('endpoint', $endpoint);
    }

    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return ResponseInterface
     * @throws \Guzzle\Http\Exception\RequestException
     */
    public function sendData($data)
    {
        $url = $this->getEndpoint() . $this->getMethod();

        $httpRequest = $this->httpClient->post($url)->addHeaders(array(
            'CMS' => 'Omnipay PaymentgateRu package',
            'Module-Version' => '0.1.0'
        ))->addPostFields(array_merge(array(
            'userName' => $this->getUserName(),
            'password' => $this->getPassword()
        ), $data));

        $httpRequest->getCurlOptions()
            ->set(CURLOPT_SSLVERSION, 6);

        try {
            $httpResponse = $httpRequest->send();
        } catch (ServerErrorResponseException $e) {
            echo $e->getMessage();

            return null;
        }
        
        echo '<pre>' . print_r($httpResponse->getRawHeaders(), true) . '</pre>';
        echo '<pre>' . print_r($httpResponse->getBody(true), true) . '</pre>';

        return new $this->responseClass($this, $httpResponse->getBody(true));
    }
}
