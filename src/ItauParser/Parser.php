<?php

namespace ItauParser;

use ItauParser\Processor\AbstractProcessor;

class Parser
{
    /**
     * @var AbstractProcessor
     */
    protected $processor;

    /**
     * @param AbstractProcessor $processor
     */
    public function __construct(AbstractProcessor $processor = null)
    {
        $this->processor = $processor;
    }

    /**
     * @param AbstractProcessor $processor
     */
    public function setProcessor(AbstractProcessor $processor)
    {
        $this->processor = $processor;
    }

    public function parse()
    {
        return $this->processor->process();
    }
}
