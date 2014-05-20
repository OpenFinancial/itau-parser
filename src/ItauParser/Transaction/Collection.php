<?php

namespace ItauParser\Transaction;

use Traversable;

class Collection implements \IteratorAggregate, \Countable
{
    /**
     * @var AbstractTransaction[]
     */
    protected $collection;

    /**
     * @param AbstractTransaction $transaction
     */
    public function add(AbstractTransaction $transaction)
    {
        $this->collection[] = $transaction;
    }

    /**
     * @return integer
     */
    public function count()
    {
        return count($this->collection);
    }

    /**
     * @return \ArrayIterator|Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->collection);
    }
}
