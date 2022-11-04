<?php

namespace Majkel\Pseudokod;

class TokenStream
{
    private int $pointer = -1;

    public function __construct(
        /** @var array<Token> $tokens */
        public readonly array $tokens
    ) {

    }

    public function curent(): Token
    {
        return $this->tokens[$this->pointer];
    }

    public function next(): Token 
    {
        $this->pointer++;
        return $this->curent();
    }

    public function peek(int $pos): Token
    {
        return $this->tokens[$this->pointer + $pos];
    }

    public function peekNonWhite(int $pos): Token
    {
        $token = $this->peek($pos);
        if ($token->kind !== TokenKind::Space) {
            return $token;
        }

        return $this->peek($pos > 0 ? $pos + 1 : $pos - 1);
    }

    public function nextNonWhite(): Token 
    {
        if ($this->next()->kind !== TokenKind::Space) {
            return $this->curent();
        }

        return $this->next();
    } 
}
