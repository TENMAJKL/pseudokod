<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

use Majkel\Pseudokod\Indentor;
use Majkel\Pseudokod\VariableManager;

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

    public function print(VariableManager $variables, int $level = 0): string
    {
        $result = Indentor::indent("if ({$this->condition->print($variables)}) {$this->block->print($variables, $level)}", $level);

        foreach ($this->else_ifs as $else_if) {
            $result .= ' else '.$else_if->print($variables, $level);
        }

        if ($this->else) {
            $result .= ' else '.$this->else->print($variables, $level);
        }

        return $result;
    }
}
