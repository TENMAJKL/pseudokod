<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

use Majkel\Pseudokod\Indentor;
use Majkel\Pseudokod\VariableManager;

class BlockNode implements Node
{
    public function __construct(
        /** @var array<Node> $code */
        public readonly array $code
    ) {
    }

    public function print(VariableManager $variables, int $level = 0): string
    {
        return
            "{\n"
            .implode("\n", array_map(fn (Node $item) => $item->print($variables, $level + 1), $this->code))
            ."\n"
            .Indentor::indent('}', $level);
    }
}
