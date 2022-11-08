<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

class InputNode implements Node
{
    public function __construct(
        /** @var array<VariableNode> $variables */
        public readonly array $variables
    ) {
    }

    public function print(int $level = 0): string
    {
        $variables = [];
        foreach ($this->variables as $var) {
            $var = $var->print();
            $variables[] = 
                $var === 'pole'
                ? 'int pole[]'
                : 'int '.$var
            ;
        }

        return implode(', ', $variables);
    }
}
