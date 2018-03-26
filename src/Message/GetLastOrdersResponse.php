<?php

namespace Omnipay\PaymentgateRu\Message;

class GetLastOrdersResponse extends AbstractCurlResponse
{
    /**
     * Is the response successful?
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->getCode() === 0;
    }

    /**
     * Response code
     *
     * @return int A response code from the payment gateway
     */
    public function getCode(): int
    {
        return (int) $this->data['errorCode'];
    }

    /**
     * Count of rows
     *
     * @return int
     */
    public function getTotalCount(): int
    {
        return (int) $this->data['totalCount'];
    }

    /**
     * Current page
     *
     * @return int
     */
    public function getPage(): int
    {
        return (int) $this->data['page'];
    }

    /**
     * Page size
     *
     * @return int
     */
    public function getPageSize(): int
    {
        return (int) $this->data['pageSize'];
    }
}
