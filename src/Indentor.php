<?php

namespace Majkel\Pseudokod;

class Indentor
{
    public static function indent(string $what, int $level = 0): string
    {
        return str_repeat(' ', $level * 4).$what;
    }
}
