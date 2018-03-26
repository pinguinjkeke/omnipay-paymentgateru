<?php

namespace Omnipay\PaymentgateRu\Message;

class VerifyEnrollmentRequestTest extends AbstractRequestTest
{
    /**
     * Array of request parameters to successfully build request object
     *
     * @return array
     */
    protected function getRequestParameters(): array
    {
        return [
            'pan' => '4111 1111 1111 1111',
        ];
    }

    public function testData()
    {
        $this->assertEquals($this->request->getData(), $this->getRequestParameters());
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('VerifyEnrollmentRequestSuccess.txt');
        
        /** @var VerifyEnrollmentResponse $response */
        $response = $this->request->send();
        
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($response->getCode(), 0);
        $this->assertEquals($response->getMessage(), 'Успешно');
        $this->assertTrue($response->getEnrolled());
        $this->assertEquals($response->getEmitterName(), 'TEST CARD');
        $this->assertEquals($response->getEmitterCountryCode(), 'RU');
    }

    public function testSendFailure()
    {
        $this->setMockHttpResponse('VerifyEnrollmentRequestFailure.txt');
        
        /** @var VerifyEnrollmentResponse $response */
        $response = $this->request->send();
        
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals($response->getCode(), 5);
        $this->assertEquals($response->getMessage(), 'Доступ запрещён');
    }
}
