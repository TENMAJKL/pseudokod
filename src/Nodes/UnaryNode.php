<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

use Majkel\Pseudokod\Indentor;

class UnaryNode implements Node
{
    public function __construct(
        public readonly string $operation,
        public readonly VariableNode $variable
    ) {
    }

    public function print(int $level = 0): string
    {
        return Indentor::indent($this->operation.$this->variable->print().';', $level);
    }
}
