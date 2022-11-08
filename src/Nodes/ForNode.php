<?php

namespace Majkel\Pseudokod\Nodes;

class ForNode
{
    public function __construct(
        public readonly VariableNode $variable,
        public readonly NumberNode $from,
        public readonly ExpressionNode $to,
        public readonly EtaReductionNode $increment,
        public readonly array $block
    ) {

    }
}
