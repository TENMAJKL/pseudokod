<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

use Majkel\Pseudokod\Indentor;

class IfNode implements Node
{
    public function __construct(
        public readonly ExpressionNode $condition,
        public readonly BlockNode $block,
        /** @var array<self> $else_ifs */
        public readonly array $else_ifs = [],
        public readonly ?BlockNode $else = null
    ) {
    }

    public function print(int $level = 0): string
    {
        $result = Indentor::indent("if ({$this->condition->print()}) {$this->block->print($level)}", $level);

        foreach ($this->else_ifs as $else_if) {
            $result .= ' else '.$else_if->print($level);
        }

        if ($this->else) {
            $result .= ' else '.$this->else->print($level);
        }

        return $result;
    }
}
