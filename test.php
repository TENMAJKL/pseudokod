<?php

use Majkel\Pseudokod\{Lexer, Parser};

include __DIR__.'/vendor/autoload.php';

$lexer = new Lexer();
$tokens = $lexer->lex('algorithm Parek(out:cs,rizek,in:parek) {
1+2*3
} // cs');
$parser = new Parser($tokens);
print_r($parser->parseAlgorithm());
