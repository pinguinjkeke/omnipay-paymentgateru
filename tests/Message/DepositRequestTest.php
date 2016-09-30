<?php

namespace Omnipay\PaymentgateRu\Message;

/**
 * Class DepositRequestTest
 *
 * @package Omnipay\PaymentgateRu\Message
 * @property DepositRequest $request
 */
class DepositRequestTest extends AbstractRequestTest
{
    /**
     * Sum to charge
     *
     * @var int
     */
    protected $amount;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        $this->amount = mt_rand(100, 10000);

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
            'orderId' => $this->orderNumber,
            'amount' => $this->amount,
            'language' => 'ru'
        );
    }

    public function testData()
    {
        $this->assertEquals($this->request->getData(), $this->getRequestParameters());

        $this->request->setLanguage('ru');
        $data = $this->request->getData();
        $this->assertEquals($data['language'], 'ru');
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('DepositRequestSuccess.txt');

        /** @var DepositResponse $response */
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($response->getCode(), 0);
        $this->assertEquals($response->getMessage(), 'Успешно');
    }

    public function testSendFailure()
    {
        $this->setMockHttpResponse('DepositRequestFailure.txt');

        /** @var DepositResponse $response */
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals($response->getCode(), 7);
        $this->assertEquals($response->getMessage(), 'Платёж должен быть в корректном состоянии');
    }
}
