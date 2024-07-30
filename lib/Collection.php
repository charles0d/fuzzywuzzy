<?php

declare(strict_types=1);

namespace FuzzyWuzzy;

/**
 * Collection provides an array-like interface for working with a set of elements.
 *
 * @author Michael Crumm <mike@crumm.net>
 */
class Collection implements \ArrayAccess, \IteratorAggregate, \Countable
{
    /** @var array */
    private $elements;

    /**
     * Collection Constructor.
     *
     * @param array $elements
     */
    public function __construct(array $elements = [ ])
    {
        $this->elements = $elements;
    }

    /**
     * Adds an element to this collection.
     *
     * @param mixed $element Elements can be of any type.
     */
    public function add(mixed $element): void
    {
        $this->elements[] = $element;
    }

    /**
     * Returns true if the given elements exists in this collection.
     */
    public function contains(mixed $element): bool
    {
        return in_array($element, $this->elements, true);
    }

    public function count(): int
    {
        return count($this->elements);
    }

    /**
     * Returns the set difference of this Collection and another comparable.
     *
     * @param array|\Traversable $cmp Value to compare against.
     * @return static
     * @throws \InvalidArgumentException When $cmp is not a valid for
     * difference.
     */
    public function difference(iterable $cmp):self
    {
        return new self(array_diff($this->elements, self::coerce($cmp)->toArray()));
    }

    public function filter(\Closure $p):self
    {
        return new self(array_filter($this->elements, $p));
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->elements);
    }

    /**
     * Returns the set intersection of this Collection and another comparable.
     */
    public function intersection(iterable $cmp): self
    {
        return new self(array_intersect($this->elements, self::coerce($cmp)->toArray()));
    }

    /**
     * Checks whether this collection is empty or not.
     */
    public function isEmpty(): bool
    {
        return empty($this->elements);
    }

    /**
     * Returns a string containing all elements of this collection with a
     * glue string.
     *
     * @return string A string representation of all the array elements in the
     * same order, with the glue string between each element.
     */
    public function join(string $glue = ' '): string
    {
        return implode($glue, $this->elements);
    }

    /**
     * Returns a new collection, the values of which are the result of mapping
     * the predicate function onto each element in this collection.
     *
     * @param \Closure $p Predicate function.
     */
    public function map(\Closure $p): self
    {
        return new self(array_map($p, $this->elements));
    }

    /**
     * Apply a multisort to this collection of elements.
     *
     * @param mixed $arg [optional]
     * @param mixed $_ [optional]
     * @return static
     */
    public function multiSort(mixed ...$args): self
    {
        if (func_num_args() < 1) { throw new \LogicException('multiSort requires at least one argument.'); }

        $elements = $this->elements;
        $args     = func_get_args();
        $args[]   = &$elements;

        call_user_func_array('array_multisort', $args);

        return new self($elements);
    }

    /**
     * @param int $offset
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset ($this->elements[$offset]);
    }

    /**
     * @param int $offset
     * @return mixed|null
     */
    public function offsetGet(mixed $offset): mixed
    {
        return isset ($this->elements[$offset]) ? $this->elements[$offset] : null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!is_null($offset)) {
            $this->elements[$offset] = $value;
            return;
        }

        $this->elements[] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->elements[$offset]);
    }

    /**
     * Returns a new collection with the elements of this collection, reversed.
     */
    public function reverse(): self
    {
        return new static(array_reverse($this->elements));
    }

    /**
     * @param int $offset
     * @param int|null $length
     * @return self
     */
    public function slice(int $offset, ?int $length = null): self
    {
        return new self(array_slice($this->elements, $offset, $length, true));
    }

    /**
     * Returns a new collection with the elements of this collection, sorted.
     *
     * @return static
     */
    public function sort(): self
    {
        $sorted = $this->elements;

        sort($sorted);

        return new self($sorted);
    }

    /**
     * Returns the elements in this collection as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->elements;
    }

    public static function coerce(iterable $elements): self
    {
        if ($elements instanceof Collection) {
            return $elements;
        } elseif ($elements instanceof \Traversable) {
            $elements = iterator_to_array($elements);
        }

        return new self($elements);
    }
}
