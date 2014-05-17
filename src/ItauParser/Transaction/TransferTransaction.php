<?php

namespace ItauParser\Transaction;

class TransferTransaction extends AbstractTransaction
{
    const TRANSFER_TYPE_TBI = 'TBI';
    const TRANSFER_TYPE_DOC = 'DOC';
    const TRANSFER_TYPE_TED = 'TED';

    const ACCOUNT_TYPE_CHECKING = 'checking';
    const ACCOUNT_TYPE_SAVING = 'saving';

    /**
     * The name of the entity responsible for the account
     *
     * @var string
     */
    protected $accountHolder;

    /**
     * There are some banks that have letters in the account number :S
     *
     * @var string
     */
    protected $accountNumber;

    /**
     * @var string Enum
     */
    protected $accountType;

    /**
     * This is the agency number in Brazil
     *
     * @var integer
     */
    protected $routingNumber;

    /**
     * @var integer
     */
    protected $bankNumber;

    /**
     * @var string Enum
     */
    protected $transferType;

    /**
     * @param string $accountHolder
     */
    public function setAccountHolder($accountHolder)
    {
        $this->accountHolder = $accountHolder;
    }

    /**
     * @return string
     */
    public function getAccountHolder()
    {
        return $this->accountHolder;
    }

    /**
     * @param string $account
     */
    public function setAccountNumber($account)
    {
        $this->accountNumber = $account;
    }

    /**
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * @param string $accountType
     */
    public function setAccountType($accountType)
    {
        $this->accountType = $accountType;
    }

    /**
     * @return string
     */
    public function getAccountType()
    {
        return $this->accountType;
    }

    /**
     * @param integer $bankCode
     */
    public function setBankNumber($bankCode)
    {
        $this->bankNumber = $bankCode;
    }

    /**
     * @return integer
     */
    public function getBankNumber()
    {
        return $this->bankNumber;
    }

    /**
     * @param integer $routingNumber
     */
    public function setRoutingNumber($routingNumber)
    {
        $this->routingNumber = $routingNumber;
    }

    /**
     * @return integer
     */
    public function getRoutingNumber()
    {
        return $this->routingNumber;
    }

    /**
     * @param string $transferType
     */
    public function setTransferType($transferType)
    {
        $this->transferType = $transferType;
    }

    /**
     * @return string
     */
    public function getTransferType()
    {
        return $this->transferType;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Transfer (' . $this->transferType . ')';
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'transfer';
    }

    /**
     * @param string $type
     *
     * @return string Enum
     */
    static public function matchTransferType($type)
    {
        switch ($type) {
            case self::TRANSFER_TYPE_TBI:
                return self::TRANSFER_TYPE_TBI;
                break;
            case self::TRANSFER_TYPE_DOC:
                return self::TRANSFER_TYPE_DOC;
                break;
            case self::TRANSFER_TYPE_TED:
                return self::TRANSFER_TYPE_TED;
                break;
            default:
                return null;
        }
    }
}