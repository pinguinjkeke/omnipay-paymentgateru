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

    public function testStatusExtended()
    {
        $this->assertTrue($this->gateway->supportsStatusExtended());
        $this->assertTrue(method_exists($this->gateway, 'statusExtended'));
        $this->assertInstanceOf(
            '\\Omnipay\\PaymentgateRu\\Message\\StatusExtendedRequest',
            $this->gateway->statusExtended()
        );
    }

    public function testReverse()
    {
        $this->assertTrue($this->gateway->supportsReverse());
        $this->assertTrue(method_exists($this->gateway, 'reverse'));
        $this->assertInstanceOf('\\Omnipay\\PaymentgateRu\\Message\\ReverseRequest', $this->gateway->reverse());
    }

    public function testRefund()
    {
        $this->assertTrue($this->gateway->supportsRefund());
        $this->assertTrue(method_exists($this->gateway, 'refund'));
        $this->assertInstanceOf('\\Omnipay\\PaymentgateRu\\Message\\RefundRequest', $this->gateway->refund());
    }

    public function testVerifyEnrollment()
    {
        $this->assertTrue($this->gateway->supportsVerifyEnrollment());
        $this->assertTrue(method_exists($this->gateway, 'verifyEnrollment'));
        $this->assertInstanceOf(
            '\\Omnipay\\PaymentgateRu\\Message\\VerifyEnrollmentRequest',
            $this->gateway->verifyEnrollment()
        );
    }

    public function testAddParams()
    {
        $this->assertTrue($this->gateway->supportsAddParams());
        $this->assertTrue(method_exists($this->gateway, 'addParams'));
        $this->assertInstanceOf('\\Omnipay\\PaymentgateRu\\Message\\AddParamsRequest', $this->gateway->addParams());
    }

    public function testGetLastOrders()
    {
        $this->assertTrue($this->gateway->supportsGetLastOrders());
        $this->assertTrue(method_exists($this->gateway, 'getLastOrders'));
        $this->assertInstanceOf(
            '\\Omnipay\\PaymentgateRu\\Message\\GetLastOrdersRequest',
            $this->gateway->getLastOrders()
        );
    }

    public function testCardBind()
    {
        $this->assertTrue($this->gateway->supportsCardBind());
        $this->assertTrue(method_exists($this->gateway, 'cardBind'));
        $this->assertInstanceOf('\\Omnipay\\PaymentgateRu\\Message\\CardBindRequest', $this->gateway->cardBind());
    }

    public function testCardUnbind()
    {
        $this->assertTrue($this->gateway->supportsCardUnbind());
        $this->assertTrue(method_exists($this->gateway, 'cardUnbind'));
        $this->assertInstanceOf('\\Omnipay\\PaymentgateRu\\Message\\CardUnbindRequest', $this->gateway->cardUnbind());
    }

    public function testCardExtendBinding()
    {
        $this->assertTrue($this->gateway->supportsCardExtendBinding());
        $this->assertTrue(method_exists($this->gateway, 'cardExtendBinding'));
        $this->assertInstanceOf(
            '\\Omnipay\\PaymentgateRu\\Message\\CardExtendBindingRequest',
            $this->gateway->cardExtendBinding()
        );
    }

    public function testGetClientBindings()
    {
        $this->assertTrue($this->gateway->supportsGetClientBindings());
        $this->assertTrue(method_exists($this->gateway, 'getClientBindings'));
        $this->assertInstanceOf(
            '\\Omnipay\\PaymentgateRu\\Message\\GetClientBindingsRequest',
            $this->gateway->getClientBindings()
        );
    }

    public function testGetCardBindings()
    {
        $this->assertTrue($this->gateway->supportsGetCardBindings());
        $this->assertTrue(method_exists($this->gateway, 'getCardBindings'));
        $this->assertInstanceOf(
            '\\Omnipay\\PaymentgateRu\\Message\\GetCardBindingsRequest',
            $this->gateway->getCardBindings()
        );
    }
}
