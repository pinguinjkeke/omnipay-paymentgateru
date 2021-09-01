<?php

namespace Omnipay\RbsUat\Message;

use Omnipay\Common\Message\ResponseInterface;

class GooglePaymentRequest extends AbstractCurlRequest
{
    /**
     * Method name from bank API
     *
     * @return string
     */
    protected function getMethod(): string
    {
        return 'google/payment.do';
    }

    /**
     * Response class name. Method will be ignored if class name passed to constructor third parameter
     *
     * @return string
     */
    public function getResponseClass(): string
    {
        return 'GooglePaymentResponse';
    }

    /**
     * Get merchant name
     *
     * @return string
     */
    public function getMerchant(): ?string
    {
        return $this->getParameter('merchant');
    }

    /**
     * Get merchant name
     *
     * @param string $merchant
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setMerchant($merchant): self
    {
        return $this->setParameter('merchant', $merchant);
    }

    /**
     * Get Payment token
     *
     * @return array|string
     */
    public function getPaymentToken()
    {
        return $this->getParameter('paymentToken');
    }

    /**
     * Set Payment token
     *
     * @param array|string $paymentToken
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setPaymentToken($paymentToken): self
    {
        return $this->setParameter('paymentToken', $paymentToken);
    }

    /**
     * Additional parameters.
     *
     * @return array|null
     */
    public function getAdditionalParameters(): ?array
    {
        return $this->getParameter('additionalParameters');
    }

    /**
     * Set array of additional parameters.
     *
     * @param array $additionalParameters
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setAdditionalParameters(array $additionalParameters): self
    {
        return $this->setParameter('additionalParameters', $additionalParameters);
    }

    /**
     * Get client id.
     *
     * @return int|null
     */
    public function getClientId(): ?int
    {
        return $this->getParameter('clientId');
    }

    /**
     * Set client id to create binding.
     *
     * @param int $clientId
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setClientId($clientId): self
    {
        return $this->setParameter('clientId', $clientId);
    }

    /**
     * Is pre auth required?
     *
     * @return bool|null
     */
    public function getPreAuth(): ?bool
    {
        return $this->getParameter('preAuth');
    }

    /**
     * Set is pre auth required.
     *
     * @param bool $preAuth
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setPreAuth($preAuth): self
    {
        return $this->setParameter('preAuth', (bool)$preAuth);
    }
    /**
     * Is protocolVersion
     *
     * @return bool|null
     */
    public function getProtocolVersion(): string
    {
        return $this->getParameter('protocolVersion') ?: 'ECv2' ;
    }

    /**
     * Set is protocolVersion.
     *
     * @param bool $protocolVersion
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setProtocolVersion($protocolVersion): self
    {
        return $this->setParameter('protocolVersion', $protocolVersion);
    }

    /**
     * Get Request headers
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return array_merge(
            parent::getHeaders(),
            ['Content-Type' => 'application/json']
        );
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
        $this->validate('merchant', 'orderNumber', 'paymentToken');

        $paymentToken = $this->getPaymentToken();

        if (\is_array($paymentToken)) {
            $paymentToken = \json_encode($paymentToken);
        }

        $data = [
            'merchant' => $this->getMerchant(),
            'orderNumber' => $this->getOrderNumber(),
            'paymentToken' => \base64_encode($paymentToken),
        ];

        foreach (['description', 'language', 'additionalParameters', 'clientId', 'preAuth', 'protocolVersion'] as $parameter) {
            $method = 'get' . ucfirst($parameter);

            if (method_exists($this, $method)) {
                $value = $this->{$method}();

                if ($value) {
                    $data[$parameter] = $value;
                }
            }
        }

        return $data;
    }

    /**
     * Send the request with specified data
     *
     * @param mixed $data The data to send
     * @return ResponseInterface
     * @throws \Psr\Http\Client\Exception\RequestException
     * @throws \Psr\Http\Client\Exception\NetworkException
     */
    public function sendData($data): ResponseInterface
    {
        $this->setProtocolVersion('ECv2');
        $url = $this->getEndpoint() . $this->getMethod();

        $httpResponse = $this->httpClient->request('POST', $url, $this->getHeaders(), \json_encode($data));

        $statusCode = $httpResponse->getStatusCode();

        if ($statusCode !== 200) {
            $json = \json_encode([
                'errorCode' => $statusCode,
                'errorMessage' => 'Server error response',
            ]);

            return new ServerErrorResponse($this, $json);
        }

        return new $this->responseClass($this, $httpResponse->getBody(true));
    }
}
