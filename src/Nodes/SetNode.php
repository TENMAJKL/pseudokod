<?php

namespace Majkel\Pseudokod\Nodes;

class SetNode
{
    public function __construct(
        public readonly VariableNode $variable,
        public readonly ExpressionNode $expression
    ) {

    }
}
