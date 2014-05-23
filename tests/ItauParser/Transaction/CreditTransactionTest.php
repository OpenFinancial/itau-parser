<?php

namespace ItauParser\Transaction;

class CreditTransactionTest extends \PHPUnit_Framework_TestCase
{
    public function testDateEffected()
    {
        $originalDate = new \DateTime();
        $clonedDate = clone $originalDate;

        $credit = new CreditTransaction();
        $credit->setDateEffected($clonedDate);

        $this->assertEquals($originalDate->getTimestamp(), $credit->getDateEffected()->getTimestamp());
    }

    public function testName()
    {
        $credit = new CreditTransaction();

        $this->assertEquals($credit->getName(), '@TODO');
    }

    public function testType()
    {
        $credit = new CreditTransaction();

        $this->assertEquals($credit->getType(), 'debit');
    }
}
 