<?php

namespace Majkel\Pseudokod\Nodes;

class CompareNode implements ExpressionNode
{
    public function __construct(
        public readonly ExpressionNode $left,
        public readonly string $operator,
        public readonly ExpressionNode $right
    ) {

    }

    public function print(): string
    {
        return 
            $this->left->print()
            .' '.$this->operator
            .' '.$this->right->print()
        ;
    }
}
