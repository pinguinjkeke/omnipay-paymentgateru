<?php

namespace Omnipay\PaymentgateRu\Message;

class StatusRequestTest extends AbstractRequestTest
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
            'language' => 'ru'
        );
    }

    public function testData()
    {
        $this->assertEquals($this->request->getData(), $this->getRequestParameters());
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('StatusRequestSuccess.txt');
        
        /** @var StatusResponse $response */
        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($response->getCode(), 0);
        $this->assertEquals($response->getMessage(), 'Успешно');
        $this->assertEquals($response->getOrderNumber(), 'package_4');
        $this->assertEquals($response->getOrderStatus(), 2);
        $this->assertEquals($response->getCardPan(), '411111**1111');
        $this->assertEquals($response->getCardExpiration(), '201912');
        $this->assertEquals($response->getCardHolder(), 'alexander avakov');
        $this->assertEquals($response->getAmount(), 1000);
        $this->assertEquals($response->getCurrency(), '810');
        $this->assertEquals($response->getIp(), '85.198.111.132');
        $this->assertEquals($response->getApprovalCode(), '123456');
        $this->assertNull($response->getClientId());
        $this->assertNull($response->getBindingId());
        $this->assertNull($response->getDate());
    }

    public function testSendFailure()
    {
        $this->setMockHttpResponse('StatusRequestFailure.txt');

        /** @var StatusResponse $response */
        $response = $this->request->send();
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals($response->getCode(), 6);
        $this->assertEquals($response->getMessage(), 'Неверный номер заказа');
    }
}
