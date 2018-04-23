<?php

namespace Omnipay\PaymentgateRu\Message;

use Omnipay\Common\Exception\RuntimeException;
use Omnipay\Common\Http\Client;
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
    abstract protected function getMethod(): string;

    /**
     * Response class name. Method will be ignored if class name passed to constructor third parameter
     *
     * @return string
     */
    abstract public function getResponseClass(): string;

    /**
     * Create a new Request
     *
     * @param \Omnipay\Common\Http\Client $httpClient A Guzzle client to make API calls with
     * @param HttpRequest $httpRequest A Symfony HTTP request object
     * @param null|string Response class name (overrides getResponseClass method). Created for test purposes
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function __construct(Client $httpClient, HttpRequest $httpRequest, $responseClass = null)
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
    public function getAmount(): int
    {
        return (int) $this->getParameter('amount');
    }

    /**
     * Get gateway user name
     *
     * @return string|null
     */
    public function getUserName(): ?string
    {
        return $this->getParameter('userName');
    }

    /**
     * Set gateway user name
     *
     * @param string $userName
     * @return \Omnipay\Common\Message\AbstractRequest|$this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setUserName($userName): self
    {
        return $this->setParameter('userName', $userName);
    }

    /**
     * Get gateway password
     *
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->getParameter('password');
    }

    /**
     * Set gateway password
     *
     * @param string $password
     * @return \Omnipay\Common\Message\AbstractRequest|$this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setPassword($password): self
    {
        return $this->setParameter('password', $password);
    }

    /**
     * Get order number
     *
     * @return int|string
     */
    public function getOrderNumber(): ?string
    {
        return $this->getParameter('orderNumber');
    }

    /**
     * Set order number
     *
     * @param int|string $orderNumber
     * @return \Omnipay\Common\Message\AbstractRequest|$this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setOrderNumber($orderNumber): self
    {
        return $this->setParameter('orderNumber', $orderNumber);
    }

    /**
     * Get language (ISO 639-1)
     *
     * @return string|null
     */
    public function getLanguage(): ?string
    {
        return $this->getParameter('language');
    }

    /**
     * Set language (ISO 639-1)
     *
     * @param string $language
     * @return \Omnipay\Common\Message\AbstractRequest|$this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setLanguage($language): self
    {
        return $this->setParameter('language', $language);
    }

    /**
     * Get endpoint URL
     *
     * @return string|null
     */
    public function getEndpoint(): ?string
    {
        return $this->getParameter('endpoint');
    }

    /**
     * Set endpoint URL
     *
     * @param string $endpoint
     * @return \Omnipay\Common\Message\AbstractRequest|$this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setEndpoint($endpoint): self
    {
        return $this->setParameter('endpoint', $endpoint);
    }

    /**
     * Get Request headers
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return [
            'CMS' => 'Omnipay PaymentgateRu package',
            'Module-Version' => '3.0.0',
        ];
    }

    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return ResponseInterface
     * @throws \Psr\Http\Client\Exception\RequestException
     * @throws \Psr\Http\Client\Exception\NetworkException
     */
    public function sendData($data): ResponseInterface
    {
        $url = "{$this->getEndpoint()}{$this->getMethod()}";
        $data = array_merge([
            'userName' => $this->getUserName(),
            'password' => $this->getPassword(),
        ], $data);
        $data = http_build_query($data);

        $httpResponse = $this->httpClient->request('POST', "{$url}?{$data}", $this->getHeaders());

        $statusCode = $httpResponse->getStatusCode();

        if ($statusCode !== 200) {
            $json = json_encode([
                'errorCode' => $statusCode,
                'errorMessage' => 'Server error response',
            ]);

            return new ServerErrorResponse($this, $json);
        }

        return new $this->responseClass($this, $httpResponse->getBody());
    }
}
