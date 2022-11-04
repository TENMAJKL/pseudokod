<?php

namespace Majkel\Pseudokod;

class Token
{
    public function __construct(
        public readonly TokenKind $kind,
        public readonly string $content
    ) {

    }
}
