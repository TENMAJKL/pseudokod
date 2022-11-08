<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

use Majkel\Pseudokod\VariableManager;

class VariableNode implements ExpressionNode
{
    public function __construct(
        public readonly string $name,
        public readonly ?ExpressionNode $array_access = null
    ) {
    }

    public function print(VariableManager $variables, int $level = 0): string
    {
        if (!$variables->is($this->name)) {
            $variables->add($this->name);
            $declaration = 'int ';
        } else {
            $declaration = '';
        }

        $array_access =
            $this->array_access
            ? '['.$this->array_access->print($variables).']'
            : ''
        ;

        return $declaration.$this->name.$array_access;
    }
}
