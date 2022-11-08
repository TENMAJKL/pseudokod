<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

class SetNode implements Node
{
    public function __construct(
        public readonly VariableNode $variable,
        public readonly ExpressionNode $expression
    ) {
    }

    public function print(): string
    {
        return "{$this->variable->print()} = {$this->expression->print()};";
    }
}
