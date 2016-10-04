<?php

namespace Omnipay\PaymentgateRu\Message;

class RefundRequestTest extends AbstractRequestTest
{
    /**
     * Array of request parameters to successfully build request object
     *
     * @return array
     */
    protected function getRequestParameters()
    {
        return array(
            'orderId' => $this->orderNumber,
            'amount' => 1000,
            'currency' => 810
        );
    }

    public function testData()
    {
        $this->assertEquals($this->request->getData(), $this->getRequestParameters());
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('RefundRequestSuccess.txt');
        
        /** @var RefundResponse $response */
        $response = $this->request->send();
        
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($response->getCode(), 0);
        $this->assertEquals($response->getMessage(), 'Успешно');
    }

    public function testSendFailure()
    {
        $this->setMockHttpResponse('RefundRequestFailure.txt');

        /** @var RefundResponse $response */
        $response = $this->request->send();
        
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals($response->getCode(), 7);
        $this->assertEquals($response->getMessage(), 'Сумма возврата превышает сумму списания');
    }
}
