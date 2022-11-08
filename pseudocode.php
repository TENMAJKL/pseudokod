<?php

declare(strict_types=1);

use Majkel\Pseudokod\Lexer;
use Majkel\Pseudokod\Parser;
use Majkel\Pseudokod\VariableManager;

include __DIR__.'/vendor/autoload.php';

$name = $argv[1] ?? throw new Exception('file does not exist');

$lexer = new Lexer();
$tokens = $lexer->lex(file_get_contents($name));
$parser = new Parser($tokens);
file_put_contents(explode('.', $name)[0].'.c', $parser->parseAlgorithm()->print(new VariableManager()));
