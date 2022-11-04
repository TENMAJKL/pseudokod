<?php

namespace Majkel\Pseudokod\Nodes;

class VariableNode implements ExpressionNode
{
    public function __construct(
        public readonly string $name,
        public readonly ?ExpressionNode $array_access = null
    ) {

    }
}