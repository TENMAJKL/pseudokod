<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

interface Node
{
    public function print(int $level = 0): string;
}
