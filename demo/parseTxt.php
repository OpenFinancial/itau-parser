<?php

include('../src/ItauParser/Parser.php');
include('../src/ItauParser/Processor/AbstractProcessor.php');
include('../src/ItauParser/Processor/TxtProcessor.php');
include('../src/ItauParser/Transaction/Collection.php');
include('../src/ItauParser/Transaction/AbstractTransaction.php');
include('../src/ItauParser/Transaction/DebitTransaction.php');
include('../src/ItauParser/Transaction/TransferTransaction.php');

$txt = file_get_contents('data/example.txt');

$parser = new \ItauParser\Parser(new \ItauParser\Processor\TxtProcessor($txt));

var_dump($parser->parse());