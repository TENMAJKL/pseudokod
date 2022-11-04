<?php

namespace Majkel\Pseudokod\Nodes;

class SwapNode
{
    public function __construct(
        public readonly VariableNode $first,
        public readonly VariableNode $second
    ) {

    } 
}
