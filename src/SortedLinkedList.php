<?php

declare(strict_types=1);

namespace Tdan\SortedLinkedList;

use Tdan\SortedLinkedList\Node;

/**
 * Class representing a sorted linked list
 *
 * @package Tdan\SortedLinkedList
 * @implements \IteratorAggregate<int, string|int>
 */
class SortedLinkedList implements \IteratorAggregate
{
    /** @var Node|null Head of the linked list */
    private ?Node $head;

    /** @var int Size of the linked list */
    private int $size;

    /** @var string Type of the linked list */
    private string $type;

    public function __construct(string $type)
    {
        if (!in_array($type, ["string", "integer"])) {
            throw new \InvalidArgumentException("Type must be either string or integer");
        }

        $this->head = null;
        $this->size = 0;
        $this->type = $type;
    }

    /**
     * Add a value to the linked list
     *
     * @param string|int $value
     *
     * @throws \InvalidArgumentException
     *
     */
    public function add(string|int $value): void
    {
        if (!$this->checkType($value)) {
            throw new \InvalidArgumentException("Type mismatched. Value must be of type {$this->type}");
        }

        $newNode = new Node($value);

        $current = $this->head;
        $prev = null;

        // Slide right to find correct insertion point
        while (
            $current != null &&
            $current->compareValue($value) < 0
        ) {
            $prev = $current;
            $current = $current->next;
        }

        if ($prev == null) {
            $this->head = $newNode;
            $newNode->next = $current;
        } else {
            $prev->next = $newNode;
            $newNode->next = $current;
        }

        $this->size++;
    }

    /**
     * Check if the linked list contains the value
     *
     * @param string|int $value
     *
     * @return bool Return true if the linked list contains the value, false otherwise.
     */
    public function contains(string|int $value): bool
    {
        if (!$this->checkType($value)) {
            throw new \InvalidArgumentException("Type mismatched. Value must be of type {$this->type}");
        }

        $current = $this->head;
        while ($current != null) {
            if ($current->compareValue($value) == 0) {
                return true;
            }

            $current = $current->next;
        }

        return false;
    }

    /**
     * Remove the first node from the linked list
     *
     * @return string|int Return the removed node
     */
    public function pop(): string|int
    {
        if ($this->head == null) {
            return "";
        }

        $node = $this->head;
        $this->head = $this->head->next;
        $this->size--;

        return $node->value;
    }

    /**
     * Remove a value from the linked list
     *
     * @param string|int $value
     */
    public function remove(string|int $value): void
    {
        if (!$this->checkType($value)) {
            throw new \InvalidArgumentException("Type mismatched. Value must be of type {$this->type}");
        }

        $current = $this->head;
        $prev = null;
        while ($current != null) {
            if ($current->compareValue($value) == 0) {
                if ($prev == null) {
                    $this->head = $current->next;
                } else {
                    $prev->next = $current->next;
                }

                $this->size--;
                return;
            }

            $prev = $current;
            $current = $current->next;
        }
    }

    /**
     * Clear the linked list
     */
    public function clear(): void
    {
        $this->head = null;
        $this->size = 0;
    }

    /**
     * Clone the linked list
     *
     * @return SortedLinkedList Return the cloned linked list
     */
    public function clone(): SortedLinkedList
    {
        $newList = new SortedLinkedList($this->type);
        $current = $this->head;
        while ($current != null) {
            $newList->add($current->value);
            $current = $current->next;
        }
        return $newList;
    }

    /**
     * Get an iterator for the linked list
     *
     * @return \Traversable<int, string|int> Iterator for the linked list
     */
    public function getIterator(): \Traversable
    {
        $current = $this->head;
        while ($current != null) {
            yield $current->value;
            $current = $current->next;
        }
    }

    /**
     * Get the size of the linked list
     *
     * @return int Size of the linked list
     */
    public function size(): int
    {
        return $this->size;
    }

    /**
     * Get the type of the linked list
     *
     * @return string Type of the linked list
     */
    public function type(): string
    {
        return $this->type;
    }

    /**
     * Convert the linked list to an array
     *
     * @return array<string|int> Array representation of the linked list
     */
    public function toArray(): array
    {
        return iterator_to_array($this->getIterator(), false);
    }

    /**
     * Check if the value is of the correct type
     *
     * @param string|int $value
     *
     * @return bool Return true if the value is of the correct type, false otherwise.
     */
    private function checkType($value): bool
    {
        return strcmp(gettype($value), $this->type) == 0;
    }
}
