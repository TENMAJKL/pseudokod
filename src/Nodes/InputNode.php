<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

class InputNode
{
    public function __construct(
        /** @var array<VariableNode> $variables */
        public readonly array $variables
    ) {
    }
}
