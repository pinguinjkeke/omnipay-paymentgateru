<?php

namespace Omnipay\PaymentgateRu\Message;

/**
 * Class AddParamsRequestTest
 *
 * @package Omnipay\PaymentgateRu\Message
 * @property AddParamsRequest $request
 */
class AddParamsRequestTest extends AbstractRequestTest
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
            'language' => 'ru',
            'params' => array(
                'hello' => 'world',
                'test' => 'case'
            )
        );
    }

    public function testAddParamMethod()
    {
        $oldData = $this->request->getParams();
        $this->request->addParam('someKey', 'someValue');
        $oldData['someKey'] = 'someValue';
        $data = $this->request->getParams();

        $this->assertEquals($data, $oldData);
        $this->assertInstanceOf(
            '\\Omnipay\\PaymentgateRu\\Message\\AddParamsRequest',
            $this->request->addParam('hello', 'world')
        );
    }

    public function testData()
    {
        $params = $this->getRequestParameters();
        $params['params'] = json_encode($params['params']);

        $this->assertEquals($this->request->getData(), $params);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('AddParamsRequestSuccess.txt');

        /** @var AddParamsResponse $response */
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($response->getCode(), 0);
        $this->assertNull($response->getMessage());
    }

    public function testSendFailure()
    {
        $this->setMockHttpResponse('AddParamsRequestFailure.txt');

        /** @var AddParamsResponse $response */
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals($response->getCode(), 6);
        $this->assertEquals($response->getMessage(), 'Неверный номер заказа');
    }
}
