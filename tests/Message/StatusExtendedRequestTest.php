<?php

namespace Omnipay\PaymentgateRu\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class StatusExtendedRequestTest extends AbstractRequestTest
{
    /**
     * Array of request parameters to successfully build request object
     *
     * @return array
     */
    protected function getRequestParameters(): array
    {
        return [
            'orderId' => 'c6268217-c51e-4ceb-b962-76eb6a91be17',
            'language' => 'ru',
        ];
    }

    public function testRequestThrowsExceptionIfNoOrderProvided()
    {
        try {
            $request = new StatusExtendedRequest($this->getHttpClient(), $this->getHttpRequest());
            $request->initialize([])->send();
        } catch (InvalidRequestException $e) {
            $this->assertEquals($e->getMessage(), 'No orderId or orderNumber provided');
        }
    }

    public function testRequestCanBeCreatedWithOrderNumberInsteadOfOrderId()
    {
        $this->setMockHttpResponse('StatusExtendedRequestSuccess.txt');

        $request = new StatusExtendedRequest($this->getHttpClient(), $this->getHttpRequest());
        $response = $request->initialize([
            'orderNumber' => 'package_4',
            'language' => 'ru',
        ])->send();

        $this->assertTrue($response->isSuccessful());
    }

    public function testData()
    {
        $this->assertEquals($this->request->getData(), $this->getRequestParameters());
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('StatusExtendedRequestSuccess.txt');

        /** @var StatusExtendedResponse $response */
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($response->getCode(), 0);
        $this->assertEquals($response->getMessage(), 'Успешно');
        $this->assertEquals($response->getOrderNumber(), 'package_4');
        $this->assertEquals($response->getOrderStatus(), 2);
        $this->assertEquals($response->getActionCode(), 0);
        $this->assertEquals($response->getActionCodeDescription(), '');
        $this->assertEquals($response->getAmount(), 1000);
        $this->assertEquals($response->getCurrency(), 810);
        $this->assertEquals($response->getDate(), '1475250343667');
        $this->assertEquals($response->getIp(), '85.198.111.132');
        $this->assertEmpty($response->getOrderDescription());

        $this->assertEquals($response->getBrowserName(), 'CHROME');
        $this->assertEquals($response->getBrowserVersion(), '53.0.2785.116');
        $this->assertEquals(
            $response->getUserAgent(),
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36'
        );
        $this->assertEquals($response->getBrowserLanguage(), 'ru');
        $this->assertEquals($response->getOs(), 'MAC_OS_X');

        $this->assertEquals($response->getCardExpiration(), '201912');
        $this->assertEquals($response->getCardHolder(), 'alexander avakov');
        $this->assertEquals($response->getCardPan(), '411111**1111');

        $this->assertEquals($response->getBankName(), 'TEST CARD');
        $this->assertEquals($response->getBankCountryCode(), 'RU');
        $this->assertEquals($response->getBankCountryName(), 'Россия');
        
        $this->assertNull($response->getClientId());
        $this->assertNull($response->getBindingId());

        $reflection = new \ReflectionClass($response);
        $method = $reflection->getMethod('getMerchantOrderParam');
        $method->setAccessible(true);
        $this->assertNull($method->invokeArgs($response, ['unexistentparameterfromtheorder']));
    }

    public function testSendFailure()
    {
        $this->setMockHttpResponse('StatusExtendedRequestFailure.txt');
    }
}
