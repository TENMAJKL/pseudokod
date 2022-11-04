<?php

namespace Majkel\Pseudokod;

class TokenStream
{
    public int $pointer = -1;

    public function __construct(
        /** @var array<Token> $tokens */
        public readonly array $tokens
    ) {

    }

    public function curent(): Token
    {
        return $this->tokens[$this->pointer];
    }

    public function next(int $pos = 1): Token 
    {
        $this->pointer += $pos;
        return $this->curent();
    }

    public function peek(int $pos = 1): ?Token
    {
        return $this->tokens[$this->pointer + $pos] ?? null;
    }

    public function peekNonWhite(int $pos = 1): ?Token
    {
        $token = $this->peek($pos);
        if ($token->kind !== TokenKind::Space) {
            return $token;
        }

        return $this->peek($pos > 0 ? $pos + 1 : $pos - 1);
    }

    public function nextNonWhite(int $pos = 1): Token 
    {
        if ($this->next($pos)->kind !== TokenKind::Space) {
            return $this->curent();
        }

        return $this->next();
    } 
}
