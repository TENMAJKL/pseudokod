<?php

namespace Majkel\Pseudokod;

class Lexer
{
    public const Re = '
        (?<ALGORITHM>algorithm)
        |(?<FOR>for)
        |(?<RANGE>->)
        |(?<SWAP><->)
        |(?<IN>in)
        |(?<OUT>out)
        |(?<IF>if)
        |(?<ELSE>else)
        |(?<WHILE>while)
        |(?<SET><-)
        |(?<UNARY>(\+\+|--))
        |(?<COMMENT>//[^\n]+)
        |(?<MATH>(\+|-|\*|/|%))
        |(?<LOGIC>(AND|OR))
        |(?<COMPARE>(<|>|<=|>=|==|!=))
        |(?<COLON>\:)
        |(?<COMMA>\,)
        |(?<SEMICOLON>;)
        |(?<NEWLINE>\n)
        |(?<SPACE>\ +)
        |(?<NAME>[a-zA-Z_]+)
        |(?<NUMBER>[0-9]+)
        |(?<OPEN>\()
        |(?<CLOSE>\))
        |(?<CURLY_OPEN>{)
        |(?<CURLY_CLOSE>})
        |(?<SQUARE_OPEN>\[)
        |(?<SQUARE_CLOSE>\])
        |(?<ERROR>.+)
    ';

    public function lex(string $code): TokenStream
    {
        preg_match_all('~'.trim(self::Re).'~xsA', $code, $matches, PREG_UNMATCHED_AS_NULL|PREG_SET_ORDER);
        $line = 0;
        return new TokenStream(array_map(function($token) use(&$line) {
            $token = array_filter($token);
            $keys = array_keys($token);
            $result = new Token(TokenKind::fromRe($keys[1]), $token[0], $line);
            if ($keys[1] === 'NEWLINE') {
                $line++;
            }
            return $result;
        }, $matches));
    }
}
