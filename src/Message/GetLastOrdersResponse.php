<?php

namespace Omnipay\PaymentgateRu\Message;

class GetLastOrdersResponse extends AbstractCurlResponse
{
    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->getCode() === 0;
    }
    
    /**
     * Response code
     *
     * @return int A response code from the payment gateway
     */
    public function getCode()
    {
        return (int) $this->data['errorCode'];
    }

    /**
     * Count of rows
     * 
     * @return int
     */
    public function getTotalCount()
    {
        return (int) $this->data['totalCount'];
    }

    /**
     * Current page
     * 
     * @return int
     */
    public function getPage()
    {
        return (int) $this->data['page'];
    }

    /**
     * Page size
     * 
     * @return int
     */
    public function getPageSize()
    {
        return (int) $this->data['pageSize'];
    }
}
