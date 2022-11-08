<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

class NewLineNode implements Node
{
    public function print(VariableManager $variables, int $level = 0): string
    {
        return "\n";
    }
}
