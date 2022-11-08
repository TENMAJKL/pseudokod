<?php

namespace Majkel\Pseudokod\Nodes;

class NewLineNode implements  Node
{
    public function print(int $level = 0): string
    {
        return "\n";
    }
}
