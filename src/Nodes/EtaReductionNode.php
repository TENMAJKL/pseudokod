<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

class EtaReductionNode
{
    public function __construct(
        public readonly string $operator,
        public readonly ?NumberNode $number = null
    ) {
    }

    public function print(int $level = 0): string
    {
        if (!$this->number) {
            return $this->operator.$this->operator;
        }

        return $this->operator.'= '.$this->number->print();
    }
}
