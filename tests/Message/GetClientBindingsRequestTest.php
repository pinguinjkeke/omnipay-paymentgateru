<?php

namespace Omnipay\PaymentgateRu\Message;

class GetClientBindingsRequestTest extends AbstractRequestTest
{
    /**
     * Client id
     * 
     * @var int
     */
    protected $clientId;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        $this->clientId = 123;
        
        parent::setUp();
    }

    /**
     * Array of request parameters to successfully build request object
     *
     * @return array
     */
    protected function getRequestParameters(): array
    {
        return [
            'clientId' => $this->clientId,
        ];
    }

    public function testData()
    {
        $this->assertEquals($this->request->getData(), $this->getRequestParameters());
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('GetClientBindingsRequestSuccess.txt');
        
        /** @var GetClientBindingsResponse $response */
        $response = $this->request->send();
        
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($response->getCode(), 0);
        $this->assertEquals($response->getMessage(), 'Успешно');
    }

    public function testSendFailure()
    {
        $this->setMockHttpResponse('GetClientBindingsRequestFailure.txt');

        /** @var GetClientBindingsResponse $response */
        $response = $this->request->send();
        
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals($response->getCode(), 2);
        $this->assertEquals($response->getMessage(), 'Информация не найдена');
    }
}
