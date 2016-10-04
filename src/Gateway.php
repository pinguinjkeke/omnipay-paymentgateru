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
     * Does gateway supports deposit?
     *
     * @return boolean
     */
    public function supportsDeposit()
    {
        return method_exists($this, 'deposit');
    }

    /**
     * Does gateway supports status?
     * 
     * @return boolean
     */
    public function supportsStatus()
    {
        return method_exists($this, 'status');
    }

    /**
     * Does gateway supports status extended?
     *
     * @return boolean
     */
    public function supportsStatusExtended()
    {
        return method_exists($this, 'statusExtended');
    }

    /**
     * Does gateway supports reverse?
     *
     * @return boolean
     */
    public function supportsReverse()
    {
        return method_exists($this, 'reverse');
    }

    /**
     * Does gateway supports card 3ds enrollment verifying?
     *
     * @return boolean
     */
    public function supportsVerifyEnrollment()
    {
        return method_exists($this, 'verifyEnrollment');
    }

    /**
     * Does gateway supports order params adding?
     * 
     * @return boolean
     */
    public function supportsAddParams()
    {
        return method_exists($this, 'addParams');
    }

    /**
     * Does gateway supports order list?
     *
     * @return boolean
     */
    public function supportsGetLastOrders()
    {
        return method_exists($this, 'getLastOrders');
    }

    /**
     * Does gateway supports card binding?
     * 
     * @return boolean
     */
    public function supportsCardBind()
    {
        return method_exists($this, 'cardBind');
    }

    /**
     * Does gateway supports card unbinding
     * 
     * @return boolean
     */
    public function supportsCardUnbind()
    {
        return method_exists($this, 'cardUnbind');
    }

    /**
     * Authorize request
     * 
     * @param array $options
     * @return Message\AuthorizeRequest
     */
    public function authorize(array $options = array())
    {
        return $this->createRequest('\\Omnipay\\PaymentgateRu\\Message\\AuthorizeRequest', $options);
    }

    /**
     * Deposit request
     *
     * @param array $options
     * @return Message\DepositRequest
     */
    public function deposit(array $options = array())
    {
        return $this->createRequest('\\Omnipay\\PaymentgateRu\\Message\\DepositRequest', $options);
    }

    /**
     * Order status request
     *
     * @param array $options
     * @return Message\StatusRequest
     */
    public function status(array $options = array())
    {
        return $this->createRequest('\\Omnipay\\PaymentgateRu\\Message\\StatusRequest', $options);
    }

    /**
     * Order status extended request
     *
     * @param array $options
     * @return Message\StatusExtendedRequest
     */
    public function statusExtended(array $options = array())
    {
        return $this->createRequest('\\Omnipay\\PaymentgateRu\\Message\\StatusExtendedRequest', $options);
    }

    /**
     * Reverse order
     *
     * @param array $options
     * @return Message\ReverseRequest
     */
    public function reverse(array $options = array())
    {
        return $this->createRequest('\\Omnipay\\PaymentgateRu\\Message\\ReverseRequest', $options);
    }

    /**
     * Refund sum from order
     *
     * @param array $options
     * @return Message\RefundRequest
     */
    public function refund(array $options = array())
    {
        return $this->createRequest('\\Omnipay\\PaymentgateRu\\Message\\RefundRequest', $options);
    }

    /**
     * Verify card 3DS enrollment
     * 
     * @param array $options
     * @return Message\VerifyEnrollmentRequest
     */
    public function verifyEnrollment(array $options = array())
    {
        return $this->createRequest('\\Omnipay\\PaymentgateRu\\Message\\VerifyEnrollmentRequest', $options);
    }

    /**
     * Add order parameters
     * 
     * @param array $options
     * @return Message\AddParamsRequest
     */
    public function addParams(array $options = array())
    {
        return $this->createRequest('\\Omnipay\\PaymentgateRu\\Message\\AddParamsRequest', $options);
    }

    /**
     * Get last orders list
     * 
     * @param array $options
     * @return Message\GetLastOrdersRequest
     */
    public function getLastOrders(array $options = array())
    {
        return $this->createRequest('\\Omnipay\\PaymentgateRu\\Message\\GetLastOrdersRequest', $options);
    }

    /**
     * Purchase request
     * 
     * @param array $options
     * @return Message\PurchaseRequest
     */
    public function purchase(array $options = array())
    {
        return $this->createRequest('\\Omnipay\\PaymentgateRu\\Message\\PurchaseRequest', $options);
    }

    /**
     * Bind card
     * 
     * @param array $options
     * @return Message\CardBindRequest
     */
    public function cardBind(array $options = array())
    {
        return $this->createRequest('\\Omnipay\\PaymentgateRu\\Message\\CardBindRequest', $options);
    }

    /**
     * Unbind card
     *
     * @param array $options
     * @return Message\CardUnbindRequest
     */
    public function cardUnbind(array $options = array())
    {
        return $this->createRequest('\\Omnipay\\PaymentgateRu\\Message\\CardUnbindRequest', $options);
    }
}
