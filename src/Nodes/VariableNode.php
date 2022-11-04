<?php

namespace Majkel\Pseudokod\Nodes;

class VariableNode
{
    public function __construct(
        public readonly string $content
    ) {

    }
}
