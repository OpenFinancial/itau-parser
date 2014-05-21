<?php

namespace ItauParser\Transaction;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testAdd()
    {
        $transfer = new TransferTransaction();

        $collection = new Collection();
        $collection->add($transfer);

        $this->assertEquals($collection->getIterator()->current(), $transfer);
    }

    public function testCount()
    {
        $transfer = new TransferTransaction();

        $collection = new Collection();
        $collection->add($transfer);

        $this->assertEquals($collection->count(), 1);
    }

    public function testGetIterator()
    {
        $transfer = new TransferTransaction();

        $collection = new Collection();
        $collection->add($transfer);

        $this->assertEquals($collection->getIterator(), new \ArrayIterator(array($transfer)));
    }
}