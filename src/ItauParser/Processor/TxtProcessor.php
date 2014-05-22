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
            $channel = AbstractTransaction::CHANNEL_UNKNOWN;

            if (substr($description, 0, 3) == AbstractTransaction::CHANNEL_INTERNET) {
                $description = substr($description, 4);
                $channel = AbstractTransaction::CHANNEL_INTERNET;
            }

            $transaction = $this->getTransactionByDescription($description, $date);
            $transaction->setChannel($channel);
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
        if ($transferType !== TransferTransaction::TRANSFER_TYPE_UNKNOWN) {
            $transaction = new TransferTransaction();
            $transaction->setTransferType($transferType);

            switch ($transferType) {
                case TransferTransaction::TRANSFER_TYPE_TBI:
                    $descriptionPart = trim(substr($description, 16));

                    if ($descriptionPart{0} == '/') {
                        $transaction->setAccountType(TransferTransaction::ACCOUNT_TYPE_SAVING);
                        $transaction->setDescription(substr($descriptionPart, 4));
                    } else {
                        $transaction->setAccountType(TransferTransaction::ACCOUNT_TYPE_CHECKING);
                        $transaction->setDescription($descriptionPart);
                    }

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
                    if (strlen($description) < 24) {
                        $transaction->setDescription(trim(substr($description, 12)));
                    } else {
                        $transaction->setAccountHolder(trim(substr($description, 12)));
                    }

                    $fields = explode('.', substr($description, 4, 8));

                    if (count($fields) > 1) {
                        $transaction->setBankNumber($fields[0]);
                        $transaction->setRoutingNumber($fields[1]);
                    }

                    break;
            }

            return $transaction;
        }

        if (substr($description, 0, 5) == 'RSHOP') {
            list(, $establishment, $dateEffected) = explode('-', $description);

            $transaction = new DebitTransaction();
            $transaction->setDescription(trim($establishment));
            $transaction->setDateEffected(
                \DateTime::createFromFormat('d/m/Y', trim($dateEffected) . $date->format('/Y'))
            );

            return $transaction;
        }

        throw new \Exception('Unable to identify transaction type, description: ' . $description);
    }
}
