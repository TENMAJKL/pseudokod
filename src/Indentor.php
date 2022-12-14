<?php

declare(strict_types=1);

namespace Majkel\Pseudokod;

class Indentor
{
    public static function indent(string $what, int $level): string
    {
        return str_repeat(' ', $level * 4).$what;
    }
}
