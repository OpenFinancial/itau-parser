<?php

namespace ItauParser\Processor;

use ItauParser\Transaction\Collection;
use ItauParser\Transaction\DebitTransaction;
use ItauParser\Transaction\TransferTransaction;

class EmailProcessor extends AbstractProcessor
{
    /**
     * @return Collection
     */
    public function process()
    {
        $collection = new Collection();

        // @todo
        $transaction = new DebitTransaction();
        $transaction->setChannel(TransferTransaction::CHANNEL_SHOP);
        $date = \DateTime::createFromFormat('Y-m-d', '2014-02-20');
        $transaction->setDateEffected($date);
        $transaction->setDate($date);
        $transaction->setAmount(-7);
        $transaction->setDescription('HAZ SALGADER2005');
        $transaction->setAmountType(TransferTransaction::AMOUNT_TYPE_DEBIT);
        $collection->add($transaction);

        return $collection;
    }
}