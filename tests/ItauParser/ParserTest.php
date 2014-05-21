<?php

namespace ItauParser;

use ItauParser\Processor\TxtProcessor;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParse()
    {
        $processor = new TxtProcessor();

        $parser = new Parser();
        $parser->setProcessor($processor);

        $this->assertEquals($parser->parse(), $processor->process());
    }
}
 