<?php

namespace ItauParser\Processor;

use ItauParser\Transaction\Collection;

abstract class AbstractProcessor
{
    /**
     * @var string
     */
    protected $data;

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    /**
     * @param string $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return Collection
     */
    abstract public function process();
}