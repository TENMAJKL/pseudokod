<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

use Majkel\Pseudokod\VariableManager;

class OutputNode implements Node
{
    public function __construct(
        /** @var array<VariableNode> $variables */
        public readonly array $variables
    ) {
    }

    public function print(VariableManager $variables, int $level = 0): string
    {
        throw new \ParseError('TODO');
    }
}
