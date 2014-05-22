<?php

namespace ItauParser\Processor;

use ItauParser\Parser;
use ItauParser\Transaction\AbstractTransaction;
use ItauParser\Transaction\Collection;
use ItauParser\Transaction\DebitTransaction;
use ItauParser\Transaction\TransferTransaction;

class EmailProcessorTest extends \PHPUnit_Framework_TestCase
{
    public function testProcess()
    {
        $data = quoted_printable_decode('
     *Compra com cart=C3=A3o de d=C3=A9bito aprovada*

* VINICIUS, *

Voc=C3=AA realizou uma compra no valor de R$ 7,00, no dia 20/05/2014, =C3=
=A0s
21:23:10h, local: HAZ SALGADER2005, com o cart=C3=A3o final: **** **** ****
7343. A compra foi aprovada e debitada da sua conta.

Pague no d=C3=A9bito com seu cart=C3=A3o Ita=C3=BA. Sem custo adicional e v=
oc=C3=AA ainda tem
50% de desconto em cinemas.
      E-mail n=C2=BA 297281821414516.
        ');

        $parser = new Parser(new EmailProcessor($data));

        $collection = new Collection();

        $transaction = new DebitTransaction();
        $transaction->setChannel(AbstractTransaction::CHANNEL_SHOP);
        $date = \DateTime::createFromFormat('Y-m-d', '2014-02-20');
        $transaction->setDateEffected($date);
        $transaction->setDate($date);
        $transaction->setAmount(-7);
        $transaction->setDescription('HAZ SALGADER2005');
        $transaction->setAmountType(TransferTransaction::AMOUNT_TYPE_DEBIT);
        $collection->add($transaction);

        $this->assertEquals($collection, $parser->parse());
    }
}