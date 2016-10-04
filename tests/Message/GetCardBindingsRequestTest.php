<?php

namespace Omnipay\PaymentgateRu\Message;
use InvalidArgumentException;

/**
 * Class GetCardBindingsRequestTest
 *
 * @package Omnipay\PaymentgateRu\Message
 * @property GetCardBindingsRequest $request
 */
class GetCardBindingsRequestTest extends AbstractRequestTest
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
            'showExpired' => 'false'
        );
    }

    public function testData()
    {
        $this->assertEquals($this->request->getData(), $this->getRequestParameters());
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('GetCardBindingsRequestSuccess.txt');

        /** @var GetCardBindingsResponse $response */
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($response->getCode(), 0);
        $this->assertEquals($response->getMessage(), 'Успешно');
    }

    public function testSendFailure()
    {
        $this->setMockHttpResponse('GetCardBindingsRequestFailure.txt');

        /** @var GetCardBindingsResponse $response */
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals($response->getCode(), 5);
        $this->assertEquals($response->getMessage(), 'Доступ запрещён');
    }

    public function testPan()
    {
        $pan = '4111111111111111';

        $this->assertInstanceOf(
            '\\Omnipay\\PaymentgateRu\\Message\\GetCardBindingsRequest',
            $this->request->setPan($pan)
        );
        $this->assertEquals($this->request->getPan(), $pan);

        $data = $this->request->getData();

        $this->assertEquals($data['pan'], $pan);
    }

    public function testGetDataShouldThrowInvalidArgumentException()
    {
        $request = new GetCardBindingsRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(array());

        try {
            $request->send();
        } catch (InvalidArgumentException $e) {
            $this->assertEquals($e->getMessage(), 'You must provide pan or bindingId to data');
        }
    }
}
