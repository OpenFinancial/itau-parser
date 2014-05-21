<?php

namespace ItauParser\Transaction;

class TransferTransactionTest extends \PHPUnit_Framework_TestCase
{
    public function testAccountHolder()
    {
        $transfer = new TransferTransaction();
        $transfer->setAccountHolder('Account Holder');
        $this->assertEquals($transfer->getAccountHolder(), 'Account Holder');
    }

    public function testAccountNumber()
    {
        $transfer = new TransferTransaction();
        $transfer->setAccountNumber('1254323');
        $this->assertEquals($transfer->getAccountNumber(), '1254323');
    }

    public function testAccountType()
    {
        $transfer = new TransferTransaction();
        $transfer->setAccountType('Personal Type');
        $this->assertEquals($transfer->getAccountType(), 'Personal Type');
    }

    public function testBankNumber()
    {
        $transfer = new TransferTransaction();
        $transfer->setBankNumber('1254323');
        $this->assertEquals($transfer->getBankNumber(), '1254323');
    }

    public function testRoutingNumber()
    {
        $transfer = new TransferTransaction();
        $transfer->setRoutingNumber(125432);
        $this->assertEquals($transfer->getRoutingNumber(), 125432);
    }

    public function testTransferType()
    {
        $transfer = new TransferTransaction();
        $transfer->setTransferType('transfer type');
        $this->assertEquals($transfer->getTransferType(), 'transfer type');
    }

    public function testMatchTransferTypeDoc()
    {
        $this->assertEquals(TransferTransaction::TRANSFER_TYPE_DOC, 'DOC');
        $this->assertEquals(TransferTransaction::TRANSFER_TYPE_TBI, 'TBI');
        $this->assertEquals(TransferTransaction::TRANSFER_TYPE_TED, 'TED');
    }
}
 