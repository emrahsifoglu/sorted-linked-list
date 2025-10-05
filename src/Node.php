<?php

declare(strict_types=1);

namespace Sif\SortedLinkedList;

/**
 * Represents a node in a linked list structure.
 *
 * Each node contains a value and a reference to the next node in the list.
 * This class is generic and can store values of any type T.
 *
 * @template T of int|string
 */
class Node
{
    /**
     * Creates a new node with the given value and optional next node reference.
     *
     * @param T $value The value to store in this node
     * @param Node<T>|null $next The next node in the list, or null if this is the last node
     */
    public function __construct(
        private int|string $value,
        private ?Node $next = null
    ) {
    }

    /**
     * Gets the value stored in this node.
     *
     * @return T The stored value
     */
    public function getValue(): int|string
    {
        return $this->value;
    }

    /**
     * Sets the value for this node.
     *
     * @param T $value The new value to store
     * @return void
     */
    public function setValue(int|string $value): void
    {
        $this->value = $value;
    }

    /**
     * Gets the reference to the next node.
     *
     * @return Node<T>|null The next node or null if this is the last node
     */
    public function getNext(): ?Node
    {
        return $this->next;
    }

    /**
     * Sets the reference to the next node.
     *
     * @param Node<T>|null $next The next node or null to make this the last node
     * @return void
     */
    public function setNext(?Node $next): void
    {
        $this->next = $next;
    }
}
