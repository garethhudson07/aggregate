<?php

namespace Aggregate;

class Set extends Aggregate
{
    /**
     * @param mixed $value
     * @return bool
     */
    public function has(mixed $value): bool
    {
        return in_array($value, $this->items);
    }

    /**
     * @param mixed $value
     * @return static
     */
    public function include(mixed $value): static
    {
        if (!$this->has($value)) {
            $this->items[] = $value;
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function first(): mixed
    {
        return $this->items[0] ?? null;
    }

    /**
     * @return mixed
     */
    public function last(): mixed
    {
        return $this->items[count($this->items) - 1] ?? null;
    }

    /**
     * @return mixed
     */
    public function penultimate(): mixed
    {
        return $this->items[count($this->items) - 2] ?? null;
    }

    /**
     * @param int $index
     * @return static
     */
    public function before(int $index): static
    {
        return (new static)->fill(
            array_slice($this->items, 0, $index)
        );
    }

    /**
     * @param int $index
     * @return static
     */
    public function after(int $index): static
    {
        return (new static)->fill(
            array_slice($this->items, $index + 1)
        );
    }

    /**
     * @param int $index
     * @return static
     */
    public function slice(int $index): static
    {
        return (new static)->fill(
            array_slice($this->items, $index)
        );
    }
}
