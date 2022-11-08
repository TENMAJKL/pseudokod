<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

class NumberNode implements ExpressionNode
{
    public function __construct(
        public readonly string $value
    ) {
    }

    public function print(): string
    {
        return $this->value;
    }
}
