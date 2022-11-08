<?php

namespace Majkel\Pseudokod\Nodes;

class UnaryNode implements Node
{
    public function __construct(
        public readonly string $operation,
        public readonly VariableNode $variable
    ) {

    }

    public function print(): string
    {
        return $this->operation.$this->variable->print().';';
    }
}
