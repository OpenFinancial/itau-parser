<?php

namespace ItauParser\Processor;

use ItauParser\Parser;
use ItauParser\Transaction\Collection;
use ItauParser\Transaction\DebitTransaction;
use ItauParser\Transaction\TransferTransaction;

class AbstractProcessorTest extends \PHPUnit_Framework_TestCase
{
    public function testData()
    {
        $data = 'ads asd asd asd';

        $processor = new TxtProcessor();
        $processor->setData($data);

        $this->assertEquals($processor->getData(), $data);
    }
}
 