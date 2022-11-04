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
        |(?<WHILE>while)
        |(?<SET><-)
        |(?<UNARY>(\+\+|--))
        |(?<COMMENT>//.+)
        |(?<MATH>(\+|-|\*|/|%))
        |(?<LOGIC>(AND|OR))
        |(?<COMPARE>(<|>|<=|>=|=))
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
        $result = preg_match_all('~'.trim(self::Re).'~xsA', $code, $matches, PREG_UNMATCHED_AS_NULL|PREG_SET_ORDER);

        return new TokenStream(array_map(function($token) {
            $token = array_filter($token);
            $keys = array_keys($token);
            return new Token(TokenKind::fromRe($keys[1]), $token[0]);
        }, $matches));
    }
}
