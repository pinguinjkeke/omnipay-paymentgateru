<?php

namespace Omnipay\PaymentgateRu\Message;

use Omnipay\PaymentgateRu\Gateway;
use Omnipay\PaymentgateRu\OrderBundle\OrderBundle;
use Tests\Examples\Order;

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
    protected function getRequestParameters(): array
    {
        return [
            'orderNumber' => $this->orderNumber,
            'amount' => $this->amount,
            'returnUrl' => $this->url,
        ];
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

        $this->assertSame($this->request->setTaxSystem(Gateway::TAX_SYSTEM_COMMON), $this->request);
        $this->assertEquals(Gateway::TAX_SYSTEM_COMMON, $this->request->getTaxSystem());
    }

    public function testData()
    {
        $this->assertEquals($this->getRequestParameters(), $this->request->getData());

        $this->request
            ->setLanguage('ru')
            ->setPageView('MOBILE')
            ->setSessionTimeoutSecs(1440)
            ->setBindingId('helloWorld')
            ->setExpirationDate('2018-12-12T12:04:12')
            ->setFailUrl('http://test.com/fail')
            ->setClientId('testClientId')
            ->setMerchantLogin('testMerchantLogin')
            ->setFeatures(AuthorizeRequest::FEATURES_AUTO_PAYMENT)
            ->setCurrency(810);

        $data = $this->request->getData();

        $this->assertEquals($data['currency'], 810);
        $this->assertEquals($data['language'], 'ru');
        $this->assertEquals($data['pageView'], 'MOBILE');
        $this->assertEquals($data['sessionTimeoutSecs'], 1440);
        $this->assertEquals($data['bindingId'], 'helloWorld');
        $this->assertEquals($data['expirationDate'], '2018-12-12T12:04:12');
        $this->assertEquals($data['failUrl'], 'http://test.com/fail');
        $this->assertEquals($data['clientId'], 'testClientId');
        $this->assertEquals($data['merchantLogin'], 'testMerchantLogin');
        $this->assertEquals($data['features'], AuthorizeRequest::FEATURES_AUTO_PAYMENT);
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

    public function testItWorksWithOrderBundles()
    {
        $orderBundle = new OrderBundle(
            new Order()
        );

        $this->assertSame($this->request->setOrderBundle($orderBundle), $this->request);
        $this->assertEquals($this->request->getOrderBundle(), $orderBundle);

        $data = $this->request->getData();
        $this->assertEquals($data['orderBundle'], json_encode($orderBundle->toArray()));
    }
}
