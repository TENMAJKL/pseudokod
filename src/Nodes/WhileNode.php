<?php

namespace Majkel\Pseudokod\Nodes;

class WhileNode
{
    public function __construct(
        public readonly ExpressionNode $condition,
        public readonly array $block,
    ) {

    }
}
