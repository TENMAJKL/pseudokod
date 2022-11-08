<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

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

    public function print(): string
    {
        // TODO if
        $result = "if ({$this->condition->print()}) {$this->block->print()}";

        foreach ($this->else_ifs as $else_if) {
            $result .= ' else '.$else_if->print();
        }

        if ($this->else) {
            $result .= ' else '.$this->else->print();
        }

        return $result;
    }
}
