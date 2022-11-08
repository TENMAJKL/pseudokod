<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

use Majkel\Pseudokod\Indentor;

class SwapNode implements Node
{
    public function __construct(
        public readonly VariableNode $first,
        public readonly VariableNode $second
    ) {
    }

    public function print(int $level = 0): string
    {
        $first = $this->first->print();
        $second = $this->second->print();

        return 
            Indentor::indent("int __h = {$first};\n", $level)
            .Indentor::indent("{$first} = {$second};\n", $level)
            .Indentor::indent("{$second} = __h;", $level)
        ;
    }
}
