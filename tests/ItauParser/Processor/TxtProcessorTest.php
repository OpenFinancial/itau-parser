<?php

namespace ItauParser\Processor;

use ItauParser\Parser;
use ItauParser\Transaction\Collection;
use ItauParser\Transaction\DebitTransaction;

class TxtProcessorTest extends \PHPUnit_Framework_TestCase
{
    public function testProcess()
    {
        $data = "17/02/2014;RSHOP-ASDQWEA    -15/02 ;-100,00\n17/02/2014;RSHOP-EWQQ DDD   -14/02 ;-50,00";
        $parser = new Parser(new TxtProcessor($data));

        $collection = new Collection();

        $transaction = new DebitTransaction();
        $transaction->setDateEffected(\DateTime::createFromFormat('m-d', '02-15'));
        $transaction->setDate(\DateTime::createFromFormat('m-d', '02-17'));
        $transaction->setAmount(-100);
        $transaction->setDescription('ASDQWEA    ');
        $transaction->setAmountType('debit');
        $collection->add($transaction);

        $transaction = new DebitTransaction();
        $transaction->setDateEffected(\DateTime::createFromFormat('m-d', '02-14'));
        $transaction->setDate(\DateTime::createFromFormat('m-d', '02-17'));
        $transaction->setAmount(-50);
        $transaction->setDescription('EWQQ DDD   ');
        $transaction->setAmountType('debit');
        $collection->add($transaction);

        $this->assertEquals($collection, $parser->parse());
    }
}
 