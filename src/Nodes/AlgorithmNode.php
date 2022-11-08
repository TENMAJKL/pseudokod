<?php

namespace Majkel\Pseudokod\Nodes;

class AlgorithmNode implements Node
{
    public function __construct(
        public readonly string $name,
        public readonly ?InputNode $input,
        public readonly ?OutputNode $output,
        public readonly BlockNode $code
    ) {

    }

    public function print(): string 
    {
        return $this->code->print();
    }
}
