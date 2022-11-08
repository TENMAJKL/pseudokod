<?php

namespace Majkel\Pseudokod\Nodes;

class UnaryNode
{
    public function __construct(
        public readonly string $operation,
        public readonly VariableNode $variable
    ) {

    }
}
