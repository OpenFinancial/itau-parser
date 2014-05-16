<?php

namespace ItauParser\Transaction;

class TransferTransaction extends AbstractTransaction
{
    /**
     * @var string
     */
    protected $account;

    /**
     * @param string $account
     */
    public function setAccount($account)
    {
        $this->account = $account;
    }

    /**
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'transfer';
    }
}