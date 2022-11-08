<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

use Majkel\Pseudokod\Indentor;
use Majkel\Pseudokod\VariableManager;

class StatementExpressionNode implements Node
{
    public function __construct(
        public readonly ExpressionNode $expression
    ) {
    }

    public function print(VariableManager $variables, int $level = 0): string
    {
        return Indentor::indent(
            $this->expression->print($variables).';',
            $level
        );
    }
}
