<?php

namespace Aggregate;

class Set extends Aggregate
{
    /**
     * @param $value
     * @return bool
     */
    public function has($value): bool
    {
        return in_array($value, $this->items);
    }

    /**
     * @param $value
     * @return static
     */
    public function include($value): self
    {
        if (!$this->has($value)) {
            $this->items[] = $value;
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function first()
    {
        return $this->items[0] ?? null;
    }

    /**
     * @return mixed
     */
    public function last()
    {
        return $this->items[count($this->items) - 1] ?? null;
    }

    /**
     * @return mixed
     */
    public function penultimate()
    {
        return $this->items[count($this->items) - 2] ?? null;
    }

    /**
     * @param int $index
     * @return static
     */
    public function before(int $index): self
    {
        return (new static)->fill(
            array_slice($this->items, 0, $index)
        );
    }

    /**
     * @param int $index
     * @return static
     */
    public function after(int $index): self
    {
        return (new static)->fill(
            array_slice($this->items, $index + 1)
        );
    }

    /**
     * @param int $index
     * @return static
     */
    public function slice(int $index): self
    {
        return (new static)->fill(
            array_slice($this->items, $index)
        );
    }
}
