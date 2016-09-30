<?php

namespace Omnipay\PaymentgateRu\Message;

/**
 * Class AuthorizeRequestTest
 *
 * @package Omnipay\PaymentgateRu\Message
 * @property AuthorizeRequest $request
 */
class AuthorizeRequestTest extends AbstractRequestTest
{
    /**
     * Amount to pay
     *
     * @var float
     */
    protected $amount;

    /**
     * Success url
     *
     * @var string
     */
    protected $url;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        $this->amount = mt_rand(1, 100);
        $this->url = 'http://hello.ru/' . uniqid('', true);

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
            'orderNumber' => $this->orderNumber,
            'amount' => $this->amount,
            'returnUrl' => $this->url
        );
    }

    public function testGettersAndSetters()
    {
        $this->assertSame($this->request->setLanguage('ru'), $this->request);
        $this->assertEquals($this->request->getLanguage(), 'ru');

        $this->assertSame($this->request->setPageView('MOBILE'), $this->request);
        $this->assertEquals($this->request->getPageView(), 'MOBILE');

        $this->assertSame($this->request->setSessionTimeoutSecs(1400), $this->request);
        $this->assertEquals($this->request->getSessionTimeoutSecs(), 1400);

        $this->assertSame($this->request->setTwoStep(true), $this->request);
        $this->assertTrue($this->request->getTwoStep());
        $this->request->setTwoStep(false);
        $this->assertFalse($this->request->getTwoStep());
    }

    public function testData()
    {
        $this->assertEquals($this->getRequestParameters(), $this->request->getData());

        $this->request->setCurrency(810);
        $data = $this->request->getData();
        $this->assertEquals($data['currency'], 810);

        $this->request->setLanguage('ru');
        $data = $this->request->getData();
        $this->assertEquals($data['language'], 'ru');

        $this->request->setPageView('MOBILE');
        $data = $this->request->getData();
        $this->assertEquals($data['pageView'], 'MOBILE');

        $this->request->setSessionTimeoutSecs(1440);
        $data = $this->request->getData();
        $this->assertEquals($data['sessionTimeoutSecs'], 1440);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('AuthorizeRequestSuccess.txt');

        /** @var AuthorizeResponse $response */
        $response = $this->request->send();
        
        $this->assertTrue($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertEquals($response->getRedirectMethod(), 'GET');
        $this->assertEmpty($response->getRedirectData());
        $this->assertNull($response->getCode());
        $this->assertNull($response->getMessage());
        $this->assertEquals($response->getTransactionId(), '627ea66f-a99f-418b-9aed-8f060e7d428d');
        $this->assertEquals(
            $response->getRedirectUrl(),
            'https://test.paymentgate.ru/testpayment/merchants/legion_city/payment_ru.html?mdOrder=627ea66f-a99f-418b-9aed-8f060e7d428d'
        );
    }

    public function testSendFailure()
    {
        $this->setMockHttpResponse('AuthorizeRequestFailure.txt');

        /** @var AuthorizeResponse $response */
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertEquals($response->getCode(), 1);
        $this->assertEquals($response->getMessage(), 'Заказ с таким номером уже обработан');
        $this->assertNull($response->getTransactionId());
    }
}