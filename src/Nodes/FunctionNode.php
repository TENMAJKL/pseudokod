<?php

namespace Majkel\Pseudokod\Nodes;

class FunctionNode implements ExpressionNode
{
    public function __construct(
        public readonly string $name,
        public readonly array $arguments,
    ) {

    }
}
