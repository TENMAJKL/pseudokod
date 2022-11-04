<?php

namespace Majkel\Pseudokod\Nodes;

class OutputNode
{
    public function __construct(
        /** @var array<VariableNode> $variables*/
        public readonly array $variables
    ) {

    }
}
