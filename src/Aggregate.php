<?php

namespace Aggregate;

use Aggregate\Contracts\Arrayable;
use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

class Aggregate implements IteratorAggregate, ArrayAccess, Countable, Arrayable
{
    /**
     * The items contained in the collection.
     *
     * @var array
     */
    protected array $items = [];

    /**
     * @param array $items
     * @return static
     */
    public function fill(array $items): static
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @param mixed $offset
     * @return static
     */
    public function unset(mixed $offset): static
    {
        $this->offsetUnset($offset);

        return $this;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->items;
    }

    /**
     * Get an iterator for the items.
     *
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    /**
     * Determine if an item exists at an offset.
     *
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->items);
    }

    /**
     * Get an item at a given offset.
     *
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet(mixed $offset): mixed {
        return $this->offsetExists($offset) ? $this->items[$offset] : null;
    }

    /**
     * Set the item at a given offset.
     *
     * @param mixed $offset
     * @param mixed $value
     * @return void
     */

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    /**
     * Unset the item at a given offset.
     *
     * @param string $offset
     * @return void
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
    }

    /**
     * Get the number of items.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @param array $items
     * @return Aggregate
     */
    public function merge(array ...$arrays): self
    {
        $this->items = array_merge($this->items, ...$arrays);

        return $this;
    }

    /**
     * Convert the collection to its string representation.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }

    /**
     * Convert the collection to json.
     *
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this);
    }

    /**
     * Get the collection of items as a plain array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return array_map(function ($item) {
            return $item instanceof Arrayable ? $item->toArray() : $item;
        }, $this->items);
    }

    /**
     * Get the JSON encodeable items
     *
     * @return mixed
     */
    public function jsonSerialize(): mixed
    {
        return $this->items;
    }
}
