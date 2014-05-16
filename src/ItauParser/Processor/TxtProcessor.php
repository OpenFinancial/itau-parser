<?php

namespace ItauParser\Processor;

use ItauParser\Transaction\AbstractTransaction;
use ItauParser\Transaction\Collection;
use ItauParser\Transaction\DebitTransaction;
use ItauParser\Transaction\TransferTransaction;

class TxtProcessor extends AbstractProcessor
{
    /**
     * @return Collection
     */
    public function process()
    {
        $collection = new Collection();

        foreach (explode(PHP_EOL, $this->data) as $line) {
            list($date, $description, $amount) = explode(';', $line);

            $date = \DateTime::createFromFormat('d/m/Y', $date);

            $transaction = $this->getTransactionByDescription($description, $date);
            $transaction->setDate($date);

            $amount = (float) str_replace('.', '', str_replace(',', '.', $amount));
            $transaction->setAmount($amount);
            $transaction->setAmountType(
                $amount >= 0 ? AbstractTransaction::AMOUNT_TYPE_CREDIT : AbstractTransaction::AMOUNT_TYPE_DEBIT
            );

            $collection->add($transaction);
        }

        return $collection;
    }

    /**
     * @param string $description
     * @param \DateTime $date
     *
     * @return AbstractTransaction
     *
     * @throws \Exception
     */
    protected function getTransactionByDescription($description, \DateTime $date)
    {
        if (substr($description, 0, 3) == 'TBI') {
            $transaction = new TransferTransaction();
            $transaction->setName('TBI');
            $transaction->setDescription(substr($description, 16));
            $transaction->setAccount(substr($description, 4, 12));

            return $transaction;
        }
        if (substr($description, 0, 5) == 'RSHOP') {
            list($name, $establishment, $dateEffected) = explode('-', $description);

            $transaction = new DebitTransaction();
            $transaction->setName($name);
            $transaction->setDescription($establishment);
            $transaction->setDateEffected(\DateTime::createFromFormat('d/m/Y', trim($dateEffected) . $date->format('/Y')));

            return $transaction;
        }

        throw new \Exception('Unable to identify transaction type');
    }
}