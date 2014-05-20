<?php

namespace ItauParser\Transaction;

abstract class AbstractTransaction
{
    const AMOUNT_TYPE_DEBIT = 'debit';
    const AMOUNT_TYPE_CREDIT = 'credit';

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @var string Enum
     */
    protected $type;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var float
     */
    protected $amount;

    /**
     * @var string Enum
     */
    protected $amountType;

    /**
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param string $amountType
     */
    public function setAmountType($amountType)
    {
        $this->amountType = $amountType;
    }

    /**
     * @return string
     */
    public function getAmountType()
    {
        return $this->amountType;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    abstract public function getName();

    /**
     * @return string
     */
    abstract public function getType();
}
