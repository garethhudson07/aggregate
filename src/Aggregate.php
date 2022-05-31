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
    protected $items = [];

    /**
     * @param $value
     * @return static
     */
    public function push($value): self
    {
        $this->items[] = $value;

        return $this;
    }

    /**
     * @param array $items
     * @return static
     */
    public function fill(array $items): self
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @param $offset
     * @return static
     */
    public function unset($offset): self
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
     * @param $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->items);
    }

    /**
     * Get an item at a given offset.
     *
     * @param $offset
     * @return mixed
     */
    public function offsetGet($offset) {
        return $this->offsetExists($offset) ? $this->items[$offset] : null;
    }

    /**
     * Set the item at a given offset.
     *
     * @param $offset
     * @param $value
     * @return void
     */

    public function offsetSet($offset, $value): void
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
    public function offsetUnset($offset): void
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
    public function jsonSerialize()
    {
        return $this->items;
    }
}
