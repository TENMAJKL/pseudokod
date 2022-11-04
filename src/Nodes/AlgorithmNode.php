<?php

namespace Majkel\Pseudokod\Nodes;

class AlgorithmNode
{
    public function __construct(
        public readonly string $name,
        public readonly ?InputNode $input,
        public readonly ?OutputNode $output,
        public readonly array $code
    ) {

    }
}
