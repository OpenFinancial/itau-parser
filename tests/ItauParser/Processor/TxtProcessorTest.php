<?php

namespace ItauParser\Processor;

use ItauParser\Parser;
use ItauParser\Transaction\AbstractTransaction;
use ItauParser\Transaction\Collection;
use ItauParser\Transaction\DebitTransaction;
use ItauParser\Transaction\TransferTransaction;

class TxtProcessorTest extends \PHPUnit_Framework_TestCase
{
    public function testProcess()
    {
        $data = array(
            '17/02/2014;RSHOP-ASDQWEA    -15/02 ;-100,00',
            '21/02/2014;DOC 237.2495FULANO BELTR;300,00',
            '04/03/2014;INT TED   902014XPTOAAAA;-234,56',
            '13/04/2014;TED 399.1842FULAN B CICL;500,00',
            '30/04/2014;TBI 1234.56789-0ASDFGHH ;-100,00',
            '15/05/2014;TBI 1234.56789-0/500    ;100,00',
        );
        $parser = new Parser(new TxtProcessor(implode(PHP_EOL, $data)));

        $collection = new Collection();

        // '17/02/2014;RSHOP-ASDQWEA    -15/02 ;-100,00',
        $transaction = new DebitTransaction();
        $transaction->setChannel(AbstractTransaction::CHANNEL_UNKNOWN);
        $transaction->setDateEffected(\DateTime::createFromFormat('m-d', '02-15'));
        $transaction->setDate(\DateTime::createFromFormat('m-d', '02-17'));
        $transaction->setAmount(-100);
        $transaction->setDescription('ASDQWEA');
        $transaction->setAmountType(TransferTransaction::AMOUNT_TYPE_DEBIT);
        $collection->add($transaction);

        // '21/02/2014;DOC 237.2495FULANO BELTR;300,00',
        $transaction = new TransferTransaction();
        $transaction->setChannel(AbstractTransaction::CHANNEL_UNKNOWN);
        $transaction->setDate(\DateTime::createFromFormat('m-d', '02-21'));
        $transaction->setAmount(300.0);
        $transaction->setAmountType(TransferTransaction::AMOUNT_TYPE_CREDIT);
        $transaction->setTransferType(TransferTransaction::TRANSFER_TYPE_DOC);
        $transaction->setBankNumber('237');
        $transaction->setRoutingNumber('2495');
        $transaction->setAccountHolder('FULANO BELTR');
        $collection->add($transaction);

        // '04/03/2014;INT TED   902014XPTOAAAA;-234,56',
        $transaction = new TransferTransaction();
        $transaction->setChannel(AbstractTransaction::CHANNEL_INTERNET);
        $transaction->setDate(\DateTime::createFromFormat('m-d', '03-04'));
        $transaction->setAmount(-234.56);
        $transaction->setDescription('XPTOAAAA');
        $transaction->setAmountType(TransferTransaction::AMOUNT_TYPE_DEBIT);
        $transaction->setTransferType(TransferTransaction::TRANSFER_TYPE_TED);
        $collection->add($transaction);

        // '13/04/2013;TED 399.1842FULAN B CICL;500,00',
        $transaction = new TransferTransaction();
        $transaction->setChannel(AbstractTransaction::CHANNEL_UNKNOWN);
        $transaction->setDate(\DateTime::createFromFormat('m-d', '04-13'));
        $transaction->setAmount(500);
        $transaction->setAccountHolder('FULAN B CICL');
        $transaction->setAmountType(TransferTransaction::AMOUNT_TYPE_CREDIT);
        $transaction->setTransferType(TransferTransaction::TRANSFER_TYPE_TED);
        $transaction->setBankNumber('399');
        $transaction->setRoutingNumber('1842');
        $collection->add($transaction);

        // '30/04/2014;TBI 1234.56789-0ASDFGHH ;-100,00',
        $transaction = new TransferTransaction();
        $transaction->setChannel(AbstractTransaction::CHANNEL_UNKNOWN);
        $transaction->setDate(\DateTime::createFromFormat('m-d', '04-30'));
        $transaction->setAmount(-100);
        $transaction->setDescription('ASDFGHH');
        $transaction->setAmountType(TransferTransaction::AMOUNT_TYPE_DEBIT);
        $transaction->setTransferType(TransferTransaction::TRANSFER_TYPE_TBI);
        $transaction->setAccountNumber('56789-0');
        $transaction->setRoutingNumber('1234');
        $transaction->setAccountType(TransferTransaction::ACCOUNT_TYPE_CHECKING);
        $collection->add($transaction);

        // '15/05/2014;TBI 1234.56789-0/500    ;100,00',
        $transaction = new TransferTransaction();
        $transaction->setChannel(AbstractTransaction::CHANNEL_UNKNOWN);
        $transaction->setDate(\DateTime::createFromFormat('m-d', '05-15'));
        $transaction->setAmount(100.0);
        $transaction->setAmountType(TransferTransaction::AMOUNT_TYPE_CREDIT);
        $transaction->setTransferType(TransferTransaction::TRANSFER_TYPE_TBI);
        $transaction->setAccountNumber('56789-0');
        $transaction->setRoutingNumber('1234');
        $transaction->setAccountType(TransferTransaction::ACCOUNT_TYPE_SAVING);
        $collection->add($transaction);

        $this->assertEquals($collection, $parser->parse());
    }

    /**
     * @expectedException \Exception
     */
    public function testProcessThrowsException()
    {
        $data = array(
            '17/02/2014;TAR 1234.56789-0ASDFGHH ;-100,00',
        );
        $parser = new Parser(new TxtProcessor(implode(PHP_EOL, $data)));
        $parser->parse();
    }
}
 