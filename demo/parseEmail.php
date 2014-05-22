<?php

$path = realpath(__DIR__ . '/../');

require $path . '/vendor/autoload.php';

$parser = new \ItauParser\Parser(
    new \ItauParser\Processor\EmailProcessor(
        quoted_printable_decode(
            file_get_contents($path . '/demo/data/email.rshop.txt')
        )
    )
);

var_dump($parser->parse());