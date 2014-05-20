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
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     */
    public function count()
    {
        return count($this->collection);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->collection);
    }
}
