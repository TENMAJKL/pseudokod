<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

class WhileNode
{
    public function __construct(
        public readonly ExpressionNode $condition,
        public readonly BlockNode $block,
    ) {
    }

    public function print(): string
    {
        return "while ({$this->condition->print()}) {$this->block->print()}";
    }
}
