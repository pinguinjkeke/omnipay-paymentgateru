<?php

namespace Omnipay\PaymentgateRu\Message;

/**
 * Class PurchaseRequestTest
 *
 * @package Omnipay\PaymentgateRu\Message
 * @property PurchaseRequest $request
 */
class PurchaseRequestTest extends AbstractRequestTest
{
    /**
     * Binding id
     *
     * @var string
     */
    protected $bindingId;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        $this->bindingId = uniqid('bindingId-', true);

        parent::setUp();
    }

    /**
     * Array of request parameters to successfully build request object
     *
     * @return array
     */
    protected function getRequestParameters()
    {
        return array(
            'mdOrder' => $this->orderNumber,
            'bindingId' => $this->bindingId,
            'ip' => '192.168.1.1',
            'language' => 'ru'
        );
    }

    public function testData()
    {
        $this->assertEquals($this->request->getData(), $this->getRequestParameters());
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('PurchaseRequestSuccess.txt');
        
        /** @var PurchaseResponse $response */
        $response = $this->request->send();
        
        $this->assertTrue($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertEquals($response->getCode(), 0);
        $this->assertNull($response->getMessage());
        $this->assertEquals($response->getRedirectUrl(), '/ok/?orderId=470bee26-212b-46c9-9ee4-a38442990224');
        $this->assertEquals($response->getInfo(), 'Ваш платёж обработан, происходит переадресация...');
        $this->assertNull($response->getAcsUrl());
        $this->assertNull($response->getPaReq());
        $this->assertNull($response->getTermUrl());
    }

    public function testSendFailure()
    {
        $this->setMockHttpResponse('PurchaseRequestFailure.txt');
        
        /** @var PurchaseResponse $response */
        $response = $this->request->send();
        
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertEquals($response->getCode(), 2);
        $this->assertEquals($response->getMessage(), 'No order found');
        $this->assertNull($response->getRedirectUrl());
        $this->assertNull($response->getInfo());
        $this->assertNull($response->getAcsUrl());
        $this->assertNull($response->getPaReq());
        $this->assertNull($response->getTermUrl());
    }

    public function testCvc()
    {
        $this->assertInstanceOf('\\Omnipay\\PaymentgateRu\\Message\\PurchaseRequest', $this->request->setCvc(456));
        $this->assertEquals($this->request->getCvc(), 456);

        $data = $this->request->getData();

        $this->assertEquals($data['cvc'], 456);
    }

    public function testEmail()
    {
        $this->assertInstanceOf(
            '\\Omnipay\\PaymentgateRu\\Message\\PurchaseRequest',
            $this->request->setEmail('a@b.ru')
        );
        $this->assertEquals($this->request->getEmail(), 'a@b.ru');

        $data = $this->request->getData();

        $this->assertEquals($data['email'], 'a@b.ru');
    }
}
