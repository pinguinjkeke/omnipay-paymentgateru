<?php

namespace Omnipay\PaymentgateRu\OrderBundle;

class OrderBundle
{
    /**
     * Order.
     *
     * @var OrderInterface
     */
    protected $order;

    /**
     * Cart position id counter.
     *
     * @var int
     */
    protected $positionId = 1;

    /**
     * OrderBundle constructor.
     *
     * @param OrderInterface $order
     */
    public function __construct(OrderInterface $order)
    {
        $this->order = $order;
    }

    /**
     * Transform order to array.
     *
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'orderCreationDate' => $this->order->getCreationDate(),
            'cartItems' => array(),
            'customerDetails' => $this->customerToArray() ?: array()
        );

        if ($this->order instanceof OrderDeliverableInterface) {
            $deliveryInfo = array();

            foreach (array('deliveryType', 'country', 'city', 'postAddress') as $field) {
                $method = 'get' . ucfirst($field);
                $deliveryInfo[$field] = $this->order->{$method}();
            }

            if ($deliveryInfo = array_filter($deliveryInfo)) {
                $array['customerDetails']['deliveryInfo'] = $deliveryInfo;
            }
        }

        $array['cartItems']['items'] = array_map(array($this, 'cartItemToArray'), $this->order->getItems());

        $this->positionId = 1;

        return $array;
    }

    /**
     * Transform cart item to array.
     *
     * @param OrderItemInterface $cartItem
     * @return array
     */
    protected function cartItemToArray(OrderItemInterface $cartItem)
    {
        $array = array(
            'positionId' => $this->positionId,
            'name' => $cartItem->getName(),
            'quantity' => array(
                'value' => $cartItem->getQuantity(),
                'measure' => $cartItem->getMeasure()
            ),
            'itemAmount' => $cartItem->getAmount(),
            'itemCode' => $cartItem->getCode(),
            'itemPrice' => $cartItem->getPrice(),
            'itemDetails' => $cartItem->getDetailParams(),
            'itemCurrency' => $cartItem->getCurrency()
        );

        if ($discountValue = $cartItem->getDiscountValue()) {
            $array['discount']['value'] = $discountValue;
            $array['discount']['type'] = $cartItem->getDiscountType();
        }

        if ($cartItem instanceof OrderItemTaxableInterface) {
            $array['tax'] = array_filter(array(
                'taxSum' => $cartItem->getTaxSum(),
                'taxType' => $cartItem->getTaxSum()
            ));
        }

        $this->positionId++;

        return array_filter($array);
    }

    /**
     * Transform customer to array.
     *
     * @return array
     */
    protected function customerToArray()
    {
        $customer = $this->order->getCustomer();
        $array = array();

        foreach (array('email', 'phone', 'contact') as $field) {
            $method = 'get' . ucfirst($field);
            $array[$field] = $customer->{$method}();
        }

        return array_filter($array);
    }
}
