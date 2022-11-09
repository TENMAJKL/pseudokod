<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

use Majkel\Pseudokod\Indentor;
use Majkel\Pseudokod\VariableManager;

class ForNode implements Node
{
    public function __construct(
        public readonly VariableNode $variable,
        public readonly NumberNode $from,
        public readonly ExpressionNode $to,
        public readonly EtaReductionNode $increment,
        public readonly BlockNode $block
    ) {
    }

    public function print(VariableManager $variables, int $level = 0): string
    {
        $variable = $this->variable->name;
        $variables->add($variable);
        $from = $this->from->print($variables);
        $to = $this->to->print($variables);
        $op =
            ((int) $from < (int) $to)
            ? '>='
            : '<='
        ;

        return Indentor::indent(
            "for (int {$variable} = {$this->from->print($variables)}; {$variable} {$op} {$this->to->print($variables)}; {$variable}{$this->increment->print($variables)}) {$this->block->print($variables, $level)}",
            $level
        );
    }
}
