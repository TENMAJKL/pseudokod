<?php

namespace Majkel\Pseudokod;

class Stack
{
    private array $data = [];

    public function push(mixed $value): self
    {
        $this->data[] = $value;
        return $this;
    }

    public function pop(): mixed
    {
        return array_pop($this->data) ?? null;
    }

    public function top(): mixed
    {
        return $this->data[count($this->data) - 1];
    }
}
