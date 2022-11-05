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
        if (!in_array($token->kind, [TokenKind::Space, TokenKind::Comment])) {
            return $token;
        }

        return $this->peek($pos > 0 ? $pos + 1 : $pos - 1);
    }

    public function nextNonWhite(int $pos = 1): Token 
    {
        if (!in_array($this->next($pos)->kind, [TokenKind::Space, TokenKind::Comment])) {
            return $this->curent();
        }

        return $this->nextNonWhite();
    } 
}
