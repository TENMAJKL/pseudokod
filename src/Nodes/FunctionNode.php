<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

class FunctionNode implements ExpressionNode
{
    public function __construct(
        public readonly string $name,
        public readonly array $arguments,
    ) {
    }

    public function print(int $level = 0): string
    {
        $args = implode(', ', array_map(fn (Node $item) => $item->print(), $this->arguments));

        return $this->name.'('.$args.')';
    }
}
