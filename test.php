<?php

use Majkel\Pseudokod\{Lexer, Parser};

include __DIR__.'/vendor/autoload.php';

$lexer = new Lexer();
$tokens = $lexer->lex('algorithm Parek(out:cs,rizek,in:parek) {
    parek(1+2, (1+3)*4)
    10
    rizek(1+1)
    parek <- 1 + 1
    parek <- parek + 1
    rizek[10] <- rizek[parek + 1]
    rizek <-> rizek[100]
}');
//print_r($tokens);
$parser = new Parser($tokens);
print_r($parser->parseAlgorithm());
