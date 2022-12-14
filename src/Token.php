<?php

declare(strict_types=1);

namespace Majkel\Pseudokod;

class Token
{
    public function __construct(
        public readonly TokenKind $kind,
        public readonly string $content,
        public readonly int $line
    ) {
    }
}
