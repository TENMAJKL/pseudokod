<?php

namespace Majkel\Pseudokod\Nodes;

class IfNode
{
    public function __construct(
        public readonly ExpressionNode $condition,
        public readonly array $block,
        /** @var array<self> $else_ifs */
        public readonly array $else_ifs = [],
        public readonly array $else = []
    ) {

    }
}
