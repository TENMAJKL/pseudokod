<?php

namespace Majkel\Pseudokod\Nodes;

class BlockNode implements Node
{
    public function __construct(
        /** @var array<Node> $code */
        public readonly array $code
    ) {

    }

    public function print(): string 
    {
        return "{\n".implode("\n", array_map(fn(Node $item) => $item->print(), $this->code))."\n}";
    }
}
