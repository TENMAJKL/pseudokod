<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

use Majkel\Pseudokod\VariableManager;

interface Node
{
    public function print(VariableManager $variables, int $level = 0): string;
}
