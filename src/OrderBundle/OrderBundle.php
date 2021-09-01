<?php

namespace Omnipay\RbsUat\OrderBundle;

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
    public function toArray(): array
    {
        $array = [
            'orderCreationDate' => $this->order->getCreationDate(),
            'cartItems' => [],
            'customerDetails' => $this->customerToArray() ?: [],
        ];

        if ($this->order instanceof OrderDeliverableInterface) {
            $deliveryInfo = [];

            foreach (['deliveryType', 'country', 'city', 'postAddress'] as $field) {
                $method = 'get' . ucfirst($field);
                $deliveryInfo[$field] = $this->order->{$method}();
            }

            if ($deliveryInfo = array_filter($deliveryInfo)) {
                $array['customerDetails']['deliveryInfo'] = $deliveryInfo;
            }
        }

        $array['cartItems']['items'] = array_map([$this, 'cartItemToArray'], $this->order->getItems());

        $this->positionId = 1;

        return $array;
    }

    /**
     * Transform cart item to array.
     *
     * @param OrderItemInterface $cartItem
     * @return array
     */
    protected function cartItemToArray(OrderItemInterface $cartItem): array
    {
        $array = [
            'positionId' => $this->positionId,
            'name' => $cartItem->getName(),
            'quantity' => [
                'value' => $cartItem->getQuantity(),
                'measure' => $cartItem->getMeasure(),
            ],
            'itemAmount' => $cartItem->getAmount(),
            'itemCode' => $cartItem->getCode(),
            'itemPrice' => $cartItem->getPrice(),
            'itemDetails' => $cartItem->getDetailParams(),
            'itemCurrency' => $cartItem->getCurrency(),
        ];

        if ($discountValue = $cartItem->getDiscountValue()) {
            $array['discount']['discountValue'] = $discountValue;
            $array['discount']['discountType'] = $cartItem->getDiscountType();
        }

        if ($cartItem instanceof OrderItemTaxableInterface) {
            $array['tax'] = array_filter([
                'taxSum' => $cartItem->getTaxSum(),
                'taxType' => $cartItem->getTaxType(),
            ]);
        }

        $this->positionId++;

        return array_filter($array);
    }

    /**
     * Transform customer to array.
     *
     * @return array
     */
    protected function customerToArray(): array
    {
        $customer = $this->order->getCustomer();
        $array = [];

        foreach (['email', 'phone', 'contact'] as $field) {
            $method = 'get' . ucfirst($field);
            $array[$field] = $customer->{$method}();
        }

        return array_filter($array);
    }
}
