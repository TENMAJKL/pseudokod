<?php

declare(strict_types=1);

namespace Majkel\Pseudokod\Nodes;

class AlgorithmNode implements Node
{
    public function __construct(
        public readonly string $name,
        public readonly ?InputNode $input,
        public readonly ?OutputNode $output,
        public readonly BlockNode $code
    ) {
    }

    public function print(int $level = 0): string
    {
        return 'void '.$this->name.'('.$this->input->print().")\n".$this->code->print();
    }
}
