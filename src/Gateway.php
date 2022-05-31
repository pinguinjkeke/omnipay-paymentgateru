<?php

namespace Omnipay\PaymentgateRu;

use Omnipay\Common\AbstractGateway;
use Omnipay\PaymentgateRu\Message\AddParamsRequest;
use Omnipay\PaymentgateRu\Message\AuthorizeRequest;
use Omnipay\PaymentgateRu\Message\CardBindRequest;
use Omnipay\PaymentgateRu\Message\CardExtendBindingRequest;
use Omnipay\PaymentgateRu\Message\CardUnbindRequest;
use Omnipay\PaymentgateRu\Message\DepositRequest;
use Omnipay\PaymentgateRu\Message\GetCardBindingsRequest;
use Omnipay\PaymentgateRu\Message\GetClientBindingsRequest;
use Omnipay\PaymentgateRu\Message\GetLastOrdersRequest;
use Omnipay\PaymentgateRu\Message\PaymentRequest;
use Omnipay\PaymentgateRu\Message\PurchaseRequest;
use Omnipay\PaymentgateRu\Message\RefundRequest;
use Omnipay\PaymentgateRu\Message\ReverseRequest;
use Omnipay\PaymentgateRu\Message\StatusExtendedRequest;
use Omnipay\PaymentgateRu\Message\StatusRequest;
use Omnipay\PaymentgateRu\Message\VerifyEnrollmentRequest;

/**
 * Class Gateway.
 *
 * Works with Paymentgate.ru gateway.
 * Supports test mode.
 * Implemented all methods from provided pdf instead of adding a card to SSL list
 * and payment through external payment system
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
    public const TEST_URL = 'https://web.rbsuat.com/ab/';

    /**
     * Production gateway url
     *
     * @var string
     */
    public const PRODUCTION_URL = 'https://pay.alfabank.ru/payment/';

    /**
     * Tax system constants
     *
     * @link https://pay.alfabank.ru/ecommerce/instructions/Connecting%20to%20the%20Fiscalization%20Service.pdf
     */
    public const TAX_SYSTEM_COMMON = 0;
    public const TAX_SYSTEM_SIMPLIFIED_INCOME = 1;
    public const TAX_SYSTEM_SIMPLIFIED_INCOME_CONSUMPTION = 2;
    public const TAX_SYSTEM_IMPUTED = 3;
    public const TAX_SYSTEM_FARMING = 4;
    public const TAX_SYSTEM_PATENT = 5;

    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName(): string
    {
        return 'PaymentgateRu';
    }

    /**
     * Define gateway parameters, in the following format:
     *
     * [
     *     'username' => '', // string variable
     *     'testMode' => false, // boolean variable
     *     'landingPage' => ['billing', 'login'], // enum variable, first item is default
     * ];
     *
     * @return array
     */
    public function getDefaultParameters(): array
    {
        return [
            'testMode' => true,
            'endpoint' => self::TEST_URL,
            'userName' => '',
            'password' => '',
            'orderNumber' => ''
        ];
    }

    /**
     * Set gateway test mode. Also changes URL
     *
     * @param bool $testMode
     * @return $this
     */
    public function setTestMode($testMode): self
    {
        $this->setEndpoint($testMode ? self::TEST_URL : self::PRODUCTION_URL);

        return $this->setParameter('testMode', $testMode);
    }

    /**
     * Get endpoint URL
     *
     * @return string
     */
    public function getEndpoint(): ?string
    {
        return $this->getParameter('endpoint');
    }

    /**
     * Set endpoint URL
     *
     * @param string $endpoint
     * @return $this
     */
    public function setEndpoint($endpoint): self
    {
        return $this->setParameter('endpoint', $endpoint);
    }

    /**
     * Get gateway user name
     *
     * @return string
     */
    public function getUserName(): ?string
    {
        return $this->getParameter('userName');
    }

    /**
     * Set gateway user name
     *
     * @param string $userName
     * @return $this
     */
    public function setUserName($userName): self
    {
        return $this->setParameter('userName', $userName);
    }

    /**
     * Get gateway password
     *
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->getParameter('password');
    }

    /**
     * Set gateway password
     *
     * @param string $password
     * @return $this
     */
    public function setPassword($password): self
    {
        return $this->setParameter('password', $password);
    }

    /**
     * Get order number
     *
     * @return int|string
     */
    public function getOrderNumber(): ?string
    {
        return $this->getParameter('orderNumber');
    }

    /**
     * Set order number
     *
     * @param int|string $orderNumber
     * @return $this
     */
    public function setOrderNumber($orderNumber): self
    {
        return $this->setParameter('orderNumber', $orderNumber);
    }

    /**
     * Does gateway supports deposit?
     *
     * @return bool
     */
    public function supportsDeposit(): bool
    {
        return method_exists($this, 'deposit');
    }

    /**
     * Does gateway supports status?
     *
     * @return bool
     */
    public function supportsStatus(): bool
    {
        return method_exists($this, 'status');
    }

    /**
     * Does gateway supports status extended?
     *
     * @return bool
     */
    public function supportsStatusExtended(): bool
    {
        return method_exists($this, 'statusExtended');
    }

    /**
     * Does gateway supports reverse?
     *
     * @return bool
     */
    public function supportsReverse(): bool
    {
        return method_exists($this, 'reverse');
    }

    /**
     * Does gateway supports card 3ds enrollment verifying?
     *
     * @return bool
     */
    public function supportsVerifyEnrollment(): bool
    {
        return method_exists($this, 'verifyEnrollment');
    }

    /**
     * Does gateway supports order params adding?
     *
     * @return bool
     */
    public function supportsAddParams(): bool
    {
        return method_exists($this, 'addParams');
    }

    /**
     * Does gateway supports order list?
     *
     * @return bool
     */
    public function supportsGetLastOrders(): bool
    {
        return method_exists($this, 'getLastOrders');
    }

    /**
     * Does gateway supports card binding?
     *
     * @return bool
     */
    public function supportsCardBind(): bool
    {
        return method_exists($this, 'cardBind');
    }

    /**
     * Does gateway supports card unbinding?
     *
     * @return bool
     */
    public function supportsCardUnbind(): bool
    {
        return method_exists($this, 'cardUnbind');
    }

    /**
     * Does gateway supports card binding extension?
     *
     * @return bool
     */
    public function supportsCardExtendBinding(): bool
    {
        return method_exists($this, 'cardExtendBinding');
    }

    /**
     * Does gateway supports client's card bindings list?
     *
     * @return bool
     */
    public function supportsGetClientBindings(): bool
    {
        return method_exists($this, 'getClientBindings');
    }

    /**
     * Does gateway supports cards bindings list?
     *
     * @return bool
     */
    public function supportsGetCardBindings(): bool
    {
        return method_exists($this, 'getCardBindings');
    }

    /**
     * Authorize request
     *
     * @param array $options
     * @return Message\AuthorizeRequest
     */
    public function authorize(array $options = []): AuthorizeRequest
    {
        return $this->createRequest(AuthorizeRequest::class, $options);
    }

    /**
     * Deposit request
     *
     * @param array $options
     * @return Message\DepositRequest
     */
    public function deposit(array $options = []): DepositRequest
    {
        return $this->createRequest(DepositRequest::class, $options);
    }

    /**
     * Order status request
     *
     * @param array $options
     * @return Message\StatusRequest
     */
    public function status(array $options = []): StatusRequest
    {
        return $this->createRequest(StatusRequest::class, $options);
    }

    /**
     * Order status extended request
     *
     * @param array $options
     * @return Message\StatusExtendedRequest
     */
    public function statusExtended(array $options = []): StatusExtendedRequest
    {
        return $this->createRequest(StatusExtendedRequest::class, $options);
    }

    /**
     * Reverse order
     *
     * @param array $options
     * @return Message\ReverseRequest
     */
    public function reverse(array $options = []): ReverseRequest
    {
        return $this->createRequest(ReverseRequest::class, $options);
    }

    /**
     * Refund sum from order
     *
     * @param array $options
     * @return Message\RefundRequest
     */
    public function refund(array $options = []): RefundRequest
    {
        return $this->createRequest(RefundRequest::class, $options);
    }

    /**
     * Verify card 3DS enrollment
     *
     * @param array $options
     * @return Message\VerifyEnrollmentRequest
     */
    public function verifyEnrollment(array $options = []): VerifyEnrollmentRequest
    {
        return $this->createRequest(VerifyEnrollmentRequest::class, $options);
    }

    /**
     * Add order parameters
     *
     * @param array $options
     * @return Message\AddParamsRequest
     */
    public function addParams(array $options = []): AddParamsRequest
    {
        return $this->createRequest(AddParamsRequest::class, $options);
    }

    /**
     * Get last orders list
     *
     * @param array $options
     * @return Message\GetLastOrdersRequest
     */
    public function getLastOrders(array $options = []): GetLastOrdersRequest
    {
        return $this->createRequest(GetLastOrdersRequest::class, $options);
    }

    /**
     * Purchase request
     *
     * @param array $options
     * @return Message\PurchaseRequest
     */
    public function purchase(array $options = []): PurchaseRequest
    {
        return $this->createRequest(PurchaseRequest::class, $options);
    }

    /**
     * ApplePay Payment request
     *
     * @param array $options
     * @return Message\PaymentRequest
     */
    public function applePay(array $options = []): PaymentRequest
    {
        return $this->createRequest(PaymentRequest::class, $options);
    }

    /**
     * Bind card
     *
     * @param array $options
     * @return Message\CardBindRequest
     */
    public function cardBind(array $options = []): CardBindRequest
    {
        return $this->createRequest(CardBindRequest::class, $options);
    }

    /**
     * Unbind card
     *
     * @param array $options
     * @return Message\CardUnbindRequest
     */
    public function cardUnbind(array $options = []): CardUnbindRequest
    {
        return $this->createRequest(CardUnbindRequest::class, $options);
    }

    /**
     * Extend card binding
     *
     * @param array $options
     * @return Message\CardExtendBindingRequest
     */
    public function cardExtendBinding(array $options = []): CardExtendBindingRequest
    {
        return $this->createRequest(CardExtendBindingRequest::class, $options);
    }

    /**
     * Get client's card bindings
     *
     * @param array $options
     * @return Message\GetClientBindingsRequest
     */
    public function getClientBindings(array $options = []): GetClientBindingsRequest
    {
        return $this->createRequest(GetClientBindingsRequest::class, $options);
    }

    /**
     * Get card's bindings
     *
     * @param array $options
     * @return Message\GetCardBindingsRequest
     */
    public function getCardBindings(array $options = []): GetCardBindingsRequest
    {
        return $this->createRequest(GetCardBindingsRequest::class, $options);
    }
}
