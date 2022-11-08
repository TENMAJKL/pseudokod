<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

class VariableNode implements ExpressionNode
{
    public function __construct(
        public readonly string $name,
        public readonly ?ExpressionNode $array_access = null
    ) {
    }

    public function print(): string
    {
        $array_access =
            $this->array_access
            ? '['.$this->array_access->print().']'
            : ''
        ;

        return $this->name.$array_access;
    }
}
