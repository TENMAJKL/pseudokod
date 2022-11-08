<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

use Majkel\Pseudokod\Indentor;
use Majkel\Pseudokod\VariableManager;

class WhileNode implements Node
{
    public function __construct(
        public readonly ExpressionNode $condition,
        public readonly BlockNode $block,
    ) {
    }

    public function print(VariableManager $variables, int $level = 0): string
    {
        return Indentor::indent(
            "while ({$this->condition->print($variables)}) {$this->block->print($variables, $level)}",
            $level
        );
    }
}
