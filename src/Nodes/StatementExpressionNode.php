<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

class StatementExpressionNode implements Node
{
    public function __construct(
        public readonly ExpressionNode $expression
    ) {
    }

    public function print(): string
    {
        return $this->expression->print().';';
    }
}