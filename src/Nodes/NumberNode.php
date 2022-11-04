<?php

namespace Majkel\Pseudokod\Nodes;

class NumberNode implements ExpressionNode
{
    public function __construct(
        public readonly string $value
    ) {

    }
}
