<?php

declare(strict_types=1);

namespace Tdan\SortedLinkedList;

/**
 * Class representing a node in the linked list
 *
 * @package Tdan\SortedLinkedList
 */
final class Node
{
    /** @var string|int Value of the node */
    public string|int $value;

    /** @var Node|null Next node */
    public ?Node $next;

    /**
     * @param string|int $value
     */
    public function __construct(string|int $value)
    {
        $this->value = $value;
        $this->next = null;
    }

    public function compareNode(Node $other): int
    {
        return $this->compareValue($other->value);
    }

    public function compareValue(string|int $value): int
    {
        if (gettype($this->value) != gettype($value)) {
            throw new \InvalidArgumentException("Cannot compare nodes of different types");
        }
        
        if (gettype($value) == "string" &&
            gettype($this->value) == "string")
        { 
            return strcmp($this->value, $value);
        }

        return $this->value - $value;
    }
}

?>
