<?php

declare(strict_types=1);

namespace Majkel\Pseudokod;

class VariableManager
{
    private array $variables = [];

    public function add(string $name): static
    {
        $this->variables[$name] = true;

        return $this;
    }

    public function is(string $name): bool
    {
        return isset($this->variables[$name]);
    }
}
