<?php

namespace Omnipay\PaymentgateRu\Message;

use Omnipay\Common\Exception\RuntimeException;
use Omnipay\Tests\TestCase;

abstract class AbstractRequestTest extends TestCase
{
    /**
     * @var AbstractCurlRequest
     */
    protected $request;

    /**
     * Gateway user name
     *
     * @var string
     */
    protected $userName;

    /**
     * Gateway password
     *
     * @var string
     */
    protected $password;

    /**
     * Order number
     *
     * @var string
     */
    protected $orderNumber;

    /**
     * Array of request parameters to successfully build request object
     *
     * @return array
     */
    abstract protected function getRequestParameters();

    /**
     * Get request class name
     *
     * @return string
     */
    protected function getRequestClassName()
    {
        // Remove last 4 symbols ("AbstractRequestTest" becomes "AbstractRequest" i.e.)
        return substr(get_class($this), 0, -4);
    }

    /**
     * Get response class name
     *
     * @return string
     */
    protected function getResponseClassName()
    {
        // Remove last 11 symbols and add "Response" ("AbstractRequestTest" becomes "AbstractResponse" i.e.)
        return substr(get_class($this), 0, -11) . 'Response';
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        $request = $this->getRequestClassName();
        $this->request = new $request($this->getHttpClient(), $this->getHttpRequest());
        $this->userName = uniqid('login', true);
        $this->password = uniqid('password', true);
        $this->orderNumber = uniqid('test_order', true);

        $this->request->initialize($this->getRequestParameters());
    }

    public function testRequestShouldThrowRuntimeExceptionIfResponseClassNotExists()
    {
        $requestClass = $this->getRequestClassName();
        $responseClass = 'UnexistentClassName';

        try {
            new $requestClass($this->getHttpClient(), $this->getHttpRequest(), $responseClass);
        } catch (RuntimeException $e) {
            $this->assertEquals(
                $e->getMessage(),
                "Response class \"\\Omnipay\\PaymentgateRu\\Message\\{$responseClass}\" not exists"
            );
        }
    }

    public function testSendDataReturnsCorrectResponseClassInstance()
    {
        $this->setMockHttpResponse('AuthorizeRequestSuccess.txt');
        $responseClass = $this->getResponseClassName();

        if (!class_exists($responseClass)) {
            throw new RuntimeException("Cannot find \"{$responseClass}\" class");
        }

        $this->assertInstanceOf($responseClass, $this->request->send());
    }

    public function testRequestShouldReturnNullOnException()
    {
        $this->setMockHttpResponse('Request502.txt');

        $this->assertNull($this->request->send());
    }

    abstract public function testData();
    
    abstract public function testSendSuccess();
    
    abstract public function testSendFailure();
}
