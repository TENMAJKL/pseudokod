<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

use Majkel\Pseudokod\Indentor;

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

    public function print(int $level = 0): string
    {
        $variable = $this->variable->print();
        $from = $this->from->print();
        $to = $this->to->print();
        $op =
            ((int) $from < (int) $to)
            ? '<'
            : '>'
        ;
        
        return Indentor::indent(
            "for (int {$variable} = {$this->from->print()}; {$variable} {$op} {$this->to->print()}; {$variable}{$this->increment->print()}) {$this->block->print($level)}",
            $level
        );
    }
}
