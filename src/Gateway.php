<?php

namespace Omnipay\PaymentgateRu;

use Omnipay\Common\AbstractGateway;

/**
 * Class Gateway
 *
 * @author Alexander Avakov (pinguinjkeke)
 * @company Meshgroup
 * @package Omnipay\PaymentgateRu
 * @link https://pay.alfabank.ru/ecommerce/instructions/Merchant%20Manual%20(RU).pdf
 */
class Gateway extends AbstractGateway
{
    /**
     * Test gateway url
     *
     * @var string
     */
    const TEST_URL = 'https://test.paymentgate.ru/testpayment/rest/';

    /**
     * Production gateway url
     *
     * @var string
     */
    const PRODUCTION_URL = 'https://engine.paymentgate.ru/payment/rest/';

    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return 'PaymentgateRu';
    }

    /**
     * Define gateway parameters, in the following format:
     *
     * array(
     *     'username' => '', // string variable
     *     'testMode' => false, // boolean variable
     *     'landingPage' => array('billing', 'login'), // enum variable, first item is default
     * );
     * 
     * @return array
     */
    public function getDefaultParameters()
    {
        return array(
            'testMode' => true,
            'endpoint' => self::TEST_URL,
            'userName' => '',
            'password' => '',
            'orderNumber' => ''
        );
    }

    /**
     * Set gateway test mode. Also changes URL
     *
     * @param bool $testMode
     * @return $this
     */
    public function setTestMode($testMode)
    {
        $this->setEndpoint($testMode ? self::TEST_URL : self::PRODUCTION_URL);

        return $this->setParameter('testMode', $testMode);
    }

    /**
     * Get endpoint URL
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->getParameter('endpoint');
    }

    /**
     * Set endpoint URL
     *
     * @param string $endpoint
     * @return $this
     */
    public function setEndpoint($endpoint)
    {
        return $this->setParameter('endpoint', $endpoint);
    }

    /**
     * Get gateway user name
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->getParameter('userName');
    }

    /**
     * Set gateway user name
     *
     * @param string $userName
     * @return $this
     */
    public function setUserName($userName)
    {
        return $this->setParameter('userName', $userName);
    }

    /**
     * Get gateway password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    /**
     * Set gateway password
     *
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        return $this->setParameter('password', $password);
    }

    /**
     * Get order number
     *
     * @return int|string
     */
    public function getOrderNumber()
    {
        return $this->getParameter('orderNumber');
    }

    /**
     * Set order number
     *
     * @param int|string $orderNumber
     * @return $this
     */
    public function setOrderNumber($orderNumber)
    {
        return $this->setParameter('orderNumber', $orderNumber);
    }

    /**
     * Authorize request
     * 
     * @param array $options
     * @return \Omnipay\PaymentgateRu\Message\AuthorizeRequest
     */
    public function authorize(array $options = array())
    {
        return $this->createRequest('\\Omnipay\\PaymentgateRu\\Message\\AuthorizeRequest', $options);
    }
}
