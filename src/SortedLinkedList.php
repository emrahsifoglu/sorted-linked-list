<?php

declare(strict_types=1);

namespace Sif\SortedLinkedList;

use InvalidArgumentException;

/**
 * A sorted linked list that maintains elements in ascending order.
 *
 * This data structure automatically maintains sort order upon insertion.
 * All elements must be of the same type (homogeneous collection).
 * Null values are not permitted.
 *
 * @template T of int|string
 */
class SortedLinkedList
{
    /**
     * The first node in the linked list.
     *
     * @var Node<T>|null
     */
    private ?Node $head = null;

    /**
     * The number of elements in the list.
     *
     * @var int
     */
    private int $size = 0;

    /**
     * The data type of elements stored in this list.
     * Determined by the first inserted element.
     *
     * @var string|null
     */
    private ?string $valueType = null;

    /**
     * Inserts a value into the list while maintaining sorted order.
     *
     * The value is inserted at the correct position to keep the list sorted
     * in ascending order. All values must be of the same type as the first
     * inserted value.
     *
     * @param T $value The value to insert (must not be null)
     * @return self<T> Returns the list instance for method chaining
     * @throws InvalidArgumentException If the value is null or of a different type than existing elements
     */
    public function insert(int|string $value): self
    {
        $actualType = get_debug_type($value);

        if ($this->valueType === null) {
            $this->valueType = $actualType;
        } elseif ($actualType !== $this->valueType) {
            throw new InvalidArgumentException(
                "Cannot insert {$actualType} into list of {$this->valueType}"
            );
        }

        $newNode = new Node($value);

        if ($this->head === null) {
            $this->head = $newNode;
            $this->size++;

            return $this;
        }

        $isString = $this->valueType === 'string';
        $isLessThanOrEqual = $isString
          ? strcmp((string)$value, (string)$this->head->getValue()) <= 0
          : $value <= $this->head->getValue();

        if ($isLessThanOrEqual) {
            $newNode->setNext($this->head);
            $this->head = $newNode;
            $this->size++;

            return $this;
        }

        $current = $this->head;
        while ($current->getNext() !== null) {
            $nextValue = $current->getNext()->getValue();
            $isGreaterThanOrEqual = $isString
              ? strcmp((string)$nextValue, (string)$value) >= 0
              : $nextValue >= $value;

            if ($isGreaterThanOrEqual) {
                break;
            }
            $current = $current->getNext();
        }

        $newNode->setNext($current->getNext());
        $current->setNext($newNode);
        $this->size++;

        return $this;
    }

    /**
     * Searches for a value in the list (optimized version).
     *
     * Performs an optimized linear search that stops early when encountering
     * a value greater than the search target (taking advantage of sorted order).
     *
     * Time Complexity:
     * - Best case: O(1) - element is at the head
     * - Average case: O(n) - though early termination often reduces comparisons
     * - Worst case: O(n) - element is at the tail or not in the list
     *
     * Space Complexity: O(1) - uses constant extra space
     *
     * @param T $value The value to search for
     * @return bool True if the value is found, false otherwise
     * @throws InvalidArgumentException When attempting to search in empty list
     * @throws InvalidArgumentException if $value type doesn't match the list's expected type
     */
    public function search(int|string $value): bool
    {
        if ($this->head === null) {
            throw new InvalidArgumentException('Cannot search in an empty list');
        }

        $searchType = get_debug_type($value);
        if ($searchType !== $this->valueType) {
            throw new InvalidArgumentException(
                "Cannot search for {$searchType} in list of {$this->valueType}"
            );
        }

        $isString = $this->valueType === 'string';
        $current = $this->head;

        while ($current !== null) {
            $currentValue = $current->getValue();

            if ($currentValue === $value) {
                return true;
            }

            $isGreater = $isString
                ? strcmp((string)$currentValue, (string)$value) > 0
                : $currentValue > $value;

            if ($isGreater) {
                return false;
            }

            $current = $current->getNext();
        }

        return false;
    }

    /**
     * Deletes the first occurrence of a value from the list.
     *
     * Performs an optimized linear search that stops early when encountering
     * a value greater than the target (taking advantage of sorted order).
     * Only the first occurrence is deleted if duplicates exist.
     *
     * Time Complexity:
     * - Best case: O(1) - element is at the head
     * - Average case: O(n) - though early termination often reduces comparisons
     * - Worst case: O(n) - element is at the tail or not in the list
     *
     * Space Complexity: O(1) - uses constant extra space
     *
     * @param T $value The value to delete
     * @return bool True if the value is found and deleted, false otherwise
     * @throws InvalidArgumentException When attempting to delete from an empty list
     * @throws InvalidArgumentException if $value type doesn't match the list's expected type
     */
    public function delete(int|string $value): bool
    {
        if ($this->head === null) {
            throw new InvalidArgumentException('Cannot delete in an empty list');
        }

        $deleteType = get_debug_type($value);
        if ($deleteType !== $this->valueType) {
            throw new InvalidArgumentException(
                "Cannot delete {$deleteType} from list of {$this->valueType}"
            );
        }

        $isString = $this->valueType === 'string';

        $headValue = $this->head->getValue();
        if (($isString && strcmp((string)$headValue, (string)$value) === 0) || (!$isString && $headValue === $value)) {
            $this->head = $this->head->getNext();
            $this->size--;
            return true;
        }

        $current = $this->head;
        while ($current->getNext() !== null) {
            $nextValue = $current->getNext()->getValue();
            $isNextGreater = $isString
                ? strcmp((string)$nextValue, (string)$value) > 0
                : $nextValue > $value;

            if ($isNextGreater) {
                return false;
            }

            $isNextEqual = $isString
                ? strcmp((string)$nextValue, (string)$value) === 0
                : $nextValue === $value;

            if ($isNextEqual) {
                $current->setNext($current->getNext()->getNext());
                $this->size--;
                return true;
            }

            $current = $current->getNext();
        }

        return false;
    }

    /**
     * Returns the head node of the list.
     *
     * @return Node<T>|null The first node, or null if the list is empty
     */
    public function getHead(): ?Node
    {
        return $this->head;
    }

    /**
     * Gets the current number of elements in the list.
     *
     * @return int The number of elements
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * Checks whether the list is empty.
     *
     * @return bool True if the list contains no elements, false otherwise
     */
    public function isEmpty(): bool
    {
        return $this->size === 0;
    }
}
