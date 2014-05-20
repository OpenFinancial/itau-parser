<?php

namespace ItauParser\Transaction;

class DebitTransaction extends AbstractTransaction
{
    /**
     * @var \DateTime
     */
    protected $dateEffected;

    /**
     * @param \DateTime $dateEffected
     */
    public function setDateEffected(\DateTime $dateEffected)
    {
        $this->dateEffected = $dateEffected;
    }

    /**
     * @return \DateTime
     */
    public function getDateEffected()
    {
        return $this->dateEffected;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '@TODO';
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'debit';
    }
}
