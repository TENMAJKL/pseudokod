<?php

use Majkel\Pseudokod\{Lexer, Parser};
use Majkel\Pseudokod\TokenStream;

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
    1 < 1
    1+2 > 10 * 3 // cs
    if (1 == 1) { 
        1 + 1
        if (1 < 2) {
            1 * 1
        } 
    }
    1+3 
}');
//print_r($tokens);
$parser = new Parser($tokens);
print_r($parser->parseAlgorithm());
