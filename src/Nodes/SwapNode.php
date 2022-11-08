<?php

namespace Majkel\Pseudokod\Nodes;

class SwapNode implements Node
{
    public function __construct(
        public readonly VariableNode $first,
        public readonly VariableNode $second
    ) {

    } 

    public function print(): string
    {
        $first = $this->first->print();
        $second = $this->second->print();
        return "int __h = {$first};
{$first} = {$second};
{$second} = __h;";
    }
}
