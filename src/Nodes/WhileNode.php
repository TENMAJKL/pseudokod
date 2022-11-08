<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

use Majkel\Pseudokod\Indentor;

class WhileNode
{
    public function __construct(
        public readonly ExpressionNode $condition,
        public readonly BlockNode $block,
    ) {
    }

    public function print(int $level = 0): string
    {
        return Indentor::indent(
            "while ({$this->condition->print()}) {$this->block->print($level)}", 
            $level
        );
    }
}
