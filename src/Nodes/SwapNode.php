<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

use Majkel\Pseudokod\Indentor;
use Majkel\Pseudokod\VariableManager;

class SwapNode implements Node
{
    public function __construct(
        public readonly VariableNode $first,
        public readonly VariableNode $second
    ) {
    }

    public function print(VariableManager $variables, int $level = 0): string
    {
        $first = $this->first->print($variables);
        $second = $this->second->print($variables);

        return
            Indentor::indent("int __h = {$first};\n", $level)
            .Indentor::indent("{$first} = {$second};\n", $level)
            .Indentor::indent("{$second} = __h;", $level)
        ;
    }
}
