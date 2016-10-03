<?php

namespace Omnipay\PaymentgateRu;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    /**
     * Gateway
     *
     * @var Gateway
     */
    protected $gateway;

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
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        parent::setUp();
        
        $this->login = uniqid('', true);
        $this->password = uniqid('', true);

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setTestMode(true)
            ->setUserName($this->userName)
            ->setPassword($this->password);
    }

    public function testAuthorize()
    {
        $this->assertTrue($this->gateway->supportsAuthorize());
        $this->assertTrue(method_exists($this->gateway, 'authorize'));
        $this->assertInstanceOf('\\Omnipay\\PaymentgateRu\\Message\\AuthorizeRequest', $this->gateway->authorize());
    }

    public function testDeposit()
    {
        $this->assertTrue($this->gateway->supportsDeposit());
        $this->assertTrue(method_exists($this->gateway, 'deposit'));
        $this->assertInstanceOf('\\Omnipay\\PaymentgateRu\\Message\\DepositRequest', $this->gateway->deposit());
    }

    public function testStatus()
    {
        $this->assertTrue($this->gateway->supportsStatus());
        $this->assertTrue(method_exists($this->gateway, 'status'));
        $this->assertInstanceOf('\\Omnipay\\PaymentgateRu\\Message\\StatusRequest', $this->gateway->status());
    }
}
