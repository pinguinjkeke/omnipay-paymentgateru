<?php

namespace Omnipay\PaymentgateRu\Message;

use \InvalidArgumentException;

/**
 * Class GetLastOrdersRequestTest
 *
 * @package Omnipay\PaymentgateRu\Message
 * @property GetLastOrdersRequest $request
 */
class GetLastOrdersRequestTest extends AbstractRequestTest
{
    /**
     * Array of request parameters to successfully build request object
     *
     * @return array
     */
    protected function getRequestParameters()
    {
        return array(
            'language' => 'ru',
            'size' => 10,
            'from' => '20160101000000',
            'to' => '20161002000000',
            'transactionStates' => 'CREATED,APPROVED,DEPOSITED,DECLINED,REVERSED,REFUNDED',
            'merchants' => '',
            'searchByCreatedDate' => 'false'
        );
    }

    public function testData()
    {
        $this->assertEquals($this->request->getData(), $this->getRequestParameters());
    }

    public function testPage()
    {
        $this->assertInstanceOf(
            '\\Omnipay\\PaymentgateRu\\Message\\GetLastOrdersRequest',
            $this->request->setPage(100)
        );
        $this->assertEquals($this->request->getPage(), 100);

        $data = $this->request->getData();

        $this->assertArrayHasKey('page', $data);
        $this->assertEquals($data['page'], 100);
    }

    public function testSetSizeShouldThrowInvalidArgumentExceptionIfMoreThanTwoHundred()
    {
        try {
            $this->request->setSize(201);
        } catch (InvalidArgumentException $e) {
            $this->assertEquals($e->getMessage(), 'Size mustn\'t be higher than 200');
        }
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('GetLastOrdersRequestSuccess.txt');
        
        /** @var GetLastOrdersResponse $response */
        $response = $this->request->send();
        
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($response->getCode(), 0);
        $this->assertNull($response->getMessage());
        $this->assertEquals($response->getPage(), 0);
        $this->assertEquals($response->getTotalCount(), 2);
        $this->assertEquals($response->getPageSize(), 10);
    }

    public function testSendFailure()
    {
        $this->setMockHttpResponse('GetLastOrdersRequestFailure.txt');
        
        /** @var GetLastOrdersResponse $response */
        $response = $this->request->send();

        $data = $response->getData();
        
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals($response->getCode(), 7);
        $this->assertEquals($response->getMessage(), 'Системная ошибка');
        $this->assertEmpty($data['orderStatuses']);
        $this->assertEquals($response->getPage(), 0);
        $this->assertEquals($response->getTotalCount(), 0);
        $this->assertEquals($response->getPageSize(), 0);
    }
}
