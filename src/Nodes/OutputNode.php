<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

use ParseError;

class OutputNode implements Node
{
    public function __construct(
        /** @var array<VariableNode> $variables */
        public readonly array $variables
    ) {
    }

    public function print(int $level = 0): string
    {
        throw new ParseError('TODO');
    }
}
