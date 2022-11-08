<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

class NumberNode implements ExpressionNode
{
    public function __construct(
        public readonly string $value
    ) {
    }

    public function print(int $level = 0): string
    {
        return $this->value;
    }
}
