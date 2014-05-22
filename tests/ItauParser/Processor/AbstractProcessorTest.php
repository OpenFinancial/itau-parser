<?php

namespace ItauParser\Processor;

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
 