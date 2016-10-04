<?php

namespace Omnipay\PaymentgateRu\Message;

use \InvalidArgumentException;

class GetLastOrdersRequest extends AbstractCurlRequest
{
    /**
     * Page number
     * 
     * @return int
     */
    public function getPage()
    {
        return (int) $this->getParameter('page');
    }

    /**
     * Set page number
     * 
     * @param int $page
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setPage($page)
    {
        return $this->setParameter('page', (int) $page);
    }
    
    /**
     * Get page size
     * 
     * @return int
     */
    public function getSize()
    {
        return $this->getParameter('size');
    }

    /**
     * Set page size
     *
     * @param int $size
     * @return $this
     * @throws \Guzzle\Common\Exception\InvalidArgumentException
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setSize($size)
    {
        if ($size > 200) {
            throw new InvalidArgumentException('Size mustn\'t be higher than 200');
        }
        
        return $this->setParameter('size', $size);
    }

    /**
     * Get start of selection (YYYYMMDDHHmmss format)
     * 
     * @return string
     */
    public function getFrom()
    {
        return $this->getParameter('from');
    }

    /**
     * Set start of selection (YYYYDDHHmmss format)
     *
     * @param string $from
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setFrom($from)
    {
        return $this->setParameter('from', $from);
    }

    /**
     * Get end of selection (YYYYDDHHmmss format)
     * 
     * @return string
     */
    public function getTo()
    {
        return $this->getParameter('to');
    }

    /**
     * Set end of selection (YYYYDDHHmmss format)
     *
     * @param string $to
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setTo($to)
    {
        return $this->setParameter('to', $to);
    }


    /**
     * Get transaction states separated by comma w/o spaces from list:
     * CREATED, APPROVED, DEPOSITED, DECLINED, REVERSED, REFUNDED
     *
     * @return string
     */
    public function getTransactionStates()
    {
        return $this->getParameter('transactionStates');
    }

    /**
     * Set transaction states separated by comma w/o spaces from list:
     * CREATED, APPROVED, DEPOSITED, DECLINED, REVERSED, REFUNDED
     *
     * @param string $transactionStates
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setTransactionStates($transactionStates)
    {
        return $this->setParameter('transactionStates', $transactionStates);
    }

    /**
     * Get list of merchant logins separated by comma
     *
     * @return string
     */
    public function getMerchants()
    {
        return $this->getParameter('merchants');
    }

    /**
     * Set list of merchant logins separated by comma
     *
     * @param string $merchants
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setMerchants($merchants)
    {
        return $this->setParameter('merchants', $merchants);
    }

    /**
     * If 'true' it will be searching by created date
     * If 'false' it will be searching by payment date
     *
     * @return string
     */
    public function getSearchByCreatedDate()
    {
        return $this->getParameter('searchByCreatedDate');
    }

    /**
     * If 'true' it will be searching by created date
     * If 'false' it will be searching by payment date
     *
     * @param $searchByCreatedDate
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setSearchByCreatedDate($searchByCreatedDate)
    {
        return $this->setParameter('searchByCreatedDate', $searchByCreatedDate);
    }
    
    /**
     * Method name from bank API
     *
     * @return string
     */
    protected function getMethod()
    {
        return 'getLastOrdersForMerchants.do';
    }

    /**
     * Response class name. Method will be ignored if class name passed to constructor third parameter
     *
     * @return string
     */
    public function getResponseClass()
    {
        return 'GetLastOrdersResponse';
    }

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('size', 'from', 'to', 'transactionStates');

        $data = array(
            'size' => $this->getSize(),
            'from' => $this->getFrom(),
            'to' => $this->getTo(),
            'transactionStates' => $this->getTransactionStates(),
            'merchants' => $this->getMerchants() ?: ''
        );

        if ($language = $this->getLanguage()) {
            $data['language'] = $language;
        }
        
        if ($page = $this->getPage()) {
            $data['page'] = $page;
        }

        $data['searchByCreatedDate'] = ($this->getSearchByCreatedDate() === 'true') ? 'true' : 'false';
        
        return $data;
    }
}
