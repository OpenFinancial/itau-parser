<?php

$path = realpath(__DIR__ . '/../');

require $path . '/vendor/autoload.php';

$parser = new \ItauParser\Parser(
    new \ItauParser\Processor\TxtProcessor(
        file_get_contents($path . '/demo/data/bankline.statement.txt')
    )
);

var_dump($parser->parse());