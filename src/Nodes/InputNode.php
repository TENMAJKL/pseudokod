<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

use Majkel\Pseudokod\VariableManager;

class InputNode implements Node
{
    public function __construct(
        /** @var array<VariableNode> $variables */
        public readonly array $variables
    ) {
    }

    public function print(VariableManager $variables, int $level = 0): string
    {
        $result = [];
        foreach ($this->variables as $var) {
            $var = $var->name;
            $result[] =
                'pole' === $var
                ? 'int pole[]'
                : 'int '.$var
            ;
            $variables->add($var);
        }

        return implode(', ', $result);
    }
}
