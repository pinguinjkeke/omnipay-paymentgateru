<?php

namespace Omnipay\PaymentgateRu\Message;

class CardExtendBindingRequestTest extends AbstractRequestTest
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
            'bindingId' => $this->bindingId,
            'newExpiry' => '201612',
            'language' => 'ru'
        );
    }

    public function testData()
    {
        $this->assertEquals($this->request->getData(), $this->getRequestParameters());
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('CardExtendBindingRequestSuccess.txt');
        
        /** @var CardExtendBindingResponse $response */
        $response = $this->request->send();
        
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($response->getCode(), 0);
        $this->assertEquals($response->getMessage(), 'Успешно');
    }

    public function testSendFailure()
    {
        $this->setMockHttpResponse('CardExtendBindingRequestFailure.txt');

        /** @var CardExtendBindingResponse $response */
        $response = $this->request->send();
        
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals($response->getCode(), 1);
        $this->assertEquals($response->getMessage(), 'Неверный [newExpiry]');
    }
}
