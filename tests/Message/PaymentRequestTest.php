<?php

namespace Omnipay\PaymentgateRu\Message;

class PaymentRequestTest extends AbstractRequestTest
{
    /**
     * Array of request parameters to successfully build request object
     *
     * @return array
     */
    protected function getRequestParameters(): array
    {
        return [
            'merchant' => $this->userName,
            'orderNumber' => $this->orderNumber,
            'paymentToken' => ['data' => '123'],
        ];
    }

    public function testData()
    {
        $parameters = $this->getRequestParameters();
        $parameters['paymentToken'] = base64_encode(json_encode($parameters['paymentToken']));
        $this->assertEquals($this->request->getData(), $parameters);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('PaymentRequestSuccess.txt');

        /** @var PaymentResponse $response */
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getMessage());
        $this->assertNull($response->getDescription());
        $this->assertEquals(0, $response->getCode());
        $this->assertEquals('123', $response->getOrderId());
    }

    public function testSendFailure()
    {
        $this->setMockHttpResponse('PaymentRequestFailure.txt');

        /** @var PaymentResponse $response */
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertEquals(1, $response->getCode());
        $this->assertEquals('error', $response->getMessage());
        $this->assertEquals('Processing Error', $response->getDescription());
        $this->assertNull($response->getOrderId());
    }
}
