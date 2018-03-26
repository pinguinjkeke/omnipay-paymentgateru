<?php

namespace Omnipay\PaymentgateRu\Message;

class ReverseRequestTest extends AbstractRequestTest
{
    /**
     * Array of request parameters to successfully build request object
     *
     * @return array
     */
    protected function getRequestParameters(): array
    {
        return [
            'orderId' => $this->orderNumber,
            'language' => 'ru',
        ];
    }

    public function testData()
    {
        $this->assertEquals($this->request->getData(), $this->getRequestParameters());
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('ReverseRequestSuccess.txt');
        
        /** @var ReverseResponse $response */
        $response = $this->request->send();
        
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($response->getCode(), 0);
        $this->assertEquals($response->getMessage(), 'Успешно');
    }

    public function testSendFailure()
    {
        $this->setMockHttpResponse('ReverseRequestFailure.txt');
        
        /** @var ReverseResponse $response */
        $response = $this->request->send();
        
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals($response->getCode(), 5);
        $this->assertEquals($response->getMessage(), 'Доступ запрещён');
    }
}
