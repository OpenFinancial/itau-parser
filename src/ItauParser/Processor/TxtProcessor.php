<?php

namespace ItauParser\Processor;

use ItauParser\Transaction\AbstractTransaction;
use ItauParser\Transaction\Collection;
use ItauParser\Transaction\DebitTransaction;
use ItauParser\Transaction\TransferTransaction;

class TxtProcessor extends AbstractProcessor
{
    const SEPARATOR_COLUMN = ';';
    const SEPARATOR_LINE = PHP_EOL;
    const FORMAT_DATE = 'd/m/Y';

    /**
     * @return Collection
     */
    public function process()
    {
        $collection = new Collection();

        if (empty($this->data)) {
            return $collection;
        }

        foreach (explode(self::SEPARATOR_LINE, $this->data) as $line) {
            list($date, $description, $amount) = explode(self::SEPARATOR_COLUMN, $line);

            $date = \DateTime::createFromFormat(self::FORMAT_DATE, $date);

            $transaction = $this->getTransactionByDescription($description, $date);
            $transaction->setDate($date);

            $amount = $this->convertBrazilianNumber($amount);
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
        $transferType = TransferTransaction::matchTransferType(substr($description, 0, 3));
        if (null !== $transferType) {
            // @todo move this hole if to a factory
            $transaction = new TransferTransaction();
            $transaction->setTransferType($transferType);

            switch ($transferType) {
                case TransferTransaction::TRANSFER_TYPE_TBI:
                    $descriptionPart = trim(substr($description, 16));

                    $transaction->setAccountType(
                        $descriptionPart{0} == '/' ?
                            TransferTransaction::ACCOUNT_TYPE_SAVING : TransferTransaction::ACCOUNT_TYPE_CHECKING
                    );
                    $transaction->setDescription($descriptionPart);

                    list($routingNumber, $accountNumber) = explode('.', substr($description, 4, 12));

                    $transaction->setRoutingNumber($routingNumber);
                    $transaction->setAccountNumber($accountNumber);
                    break;
                case TransferTransaction::TRANSFER_TYPE_DOC:
                    $transaction->setAccountHolder(trim(substr($description, 12)));

                    list($bankNumber, $routingNumber) = explode('.', substr($description, 4, 8));

                    $transaction->setBankNumber($bankNumber);
                    $transaction->setRoutingNumber($routingNumber);
                    break;
                case TransferTransaction::TRANSFER_TYPE_TED:
                    // @todo
                    break;
            }

            return $transaction;
        }

        if (substr($description, 0, 5) == 'RSHOP') {
            list($name, $establishment, $dateEffected) = explode('-', $description);

            $transaction = new DebitTransaction();
            $transaction->setDescription(trim($establishment));
            $transaction->setDateEffected(\DateTime::createFromFormat('d/m/Y', trim($dateEffected) . $date->format('/Y')));

            return $transaction;
        }

        throw new \Exception('Unable to identify transaction type');
    }
}