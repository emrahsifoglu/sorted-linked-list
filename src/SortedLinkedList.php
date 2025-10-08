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
 * @template T of int|string
 * @implements \IteratorAggregate<int, T>
 */
class SortedLinkedList implements \Countable, \IteratorAggregate
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
     * Retrieves an external iterator for the list.
     *
     * This implementation uses a **lazy generator** to traverse the linked list
     * without creating intermediate arrays, allowing for efficient iteration
     * even over large lists.
     *
     * Each iteration yields the node's value in ascending order.
     *
     * @return \Traversable<int, T>
     */
    public function getIterator(): \Traversable
    {
        $current = $this->head;

        while ($current !== null) {
            yield $current->getValue();
            $current = $current->getNext();
        }
    }

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

        if ($this->compare($value, $this->head->getValue()) <= 0) {
            $newNode->setNext($this->head);
            $this->head = $newNode;
            $this->size++;
            return $this;
        }

        $current = $this->head;

        while ($current->getNext() !== null) {
            $nextValue = $current->getNext()->getValue();

            if ($this->compare($nextValue, $value) >= 0) {
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

        $current = $this->head;

        while ($current !== null) {
            $currentValue = $current->getValue();

            if ($currentValue === $value) {
                return true;
            }

            if ($this->compare($current->getValue(), $value) > 0) {
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

        if ($this->head->getValue() === $value) {
            $this->head = $this->head->getNext();
            $this->size--;
            return true;
        }

        $current = $this->head;

        while ($current->getNext() !== null) {
            $nextValue = $current->getNext()->getValue();

            if ($this->compare($nextValue, $value) > 0) {
                return false;
            }

            if ($nextValue === $value) {
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
     * This method is part of the `Countable` interface.
     * It is automatically called when `count($list)` is used.
     *
     * @return int The number of elements
     */
    public function count(): int
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

    /**
     * Converts the sorted linked list to a standard PHP array.
     *
     * @return array<T> A numerically indexed array containing all list elements in sorted order.
     */
    public function toArray(): array
    {
        return [...$this];
    }

    /**
     * Creates a new SortedLinkedList instance from a given array.
     *
     * This static factory method validates type consistency, sorts the input array,
     * and builds the linked list directly by connecting nodes sequentially. This
     * approach is more efficient than using insert() for each element.
     *
     * Time Complexity: O(n log n) - most of the time is spent sorting the array.
     * Space Complexity: O(n) - creates n nodes for the linked list.
     *
     * Note: Using insert() for each element would result in O(n²) time complexity,
     * as each insertion requires traversing the list to find the correct position.
     *
     * @param array<T> $values The array of values to populate the list with.
     * @return self<T> A new SortedLinkedList instance.
     * @throws InvalidArgumentException If the array contains elements of mixed types.
     */
    public static function fromArray(array $values): self
    {
        /** @var self<T> $list */
        $list = new self();

        if (count($values) === 0) {
            return $list;
        }

        $firstType = get_debug_type($values[array_key_first($values)]);

        foreach ($values as $value) {
            $currentType = get_debug_type($value);
            if ($currentType !== $firstType) {
                throw new InvalidArgumentException(
                    "Mixed types in array: expected {$firstType}, found {$currentType}"
                );
            }
        }

        sort($values, $firstType === 'string' ? SORT_STRING : SORT_NUMERIC);

        $list->valueType = $firstType;
        $list->head = new Node($values[0]);
        $list->size = 1;

        $currentNode = $list->head;

        for ($i = 1; $i < count($values); $i++) {
            $newNode = new Node($values[$i]);
            $currentNode->setNext($newNode);
            $currentNode = $newNode;
            $list->size++;
        }

        return $list;
    }

    /**
     * Resets the list, removing all elements and resetting the value type.
     *
     * This method effectively empties the list, making it ready to accept new
     * elements of any type (int or string) as the first element.
     *
     * @return self<T> Returns the instance for method chaining.
     */
    public function clear(): self
    {
        $this->head = null;
        $this->size = 0;
        $this->valueType = null;

        return $this;
    }

    /**
     * Compares two values according to the list's value type.
     *
     * @param T $a First value to compare
     * @param T $b Second value to compare
     * @return int Negative if a < b, 0 if a == b, positive if a > b
     */
    private function compare(int|string $a, int|string $b): int
    {
        return match ($this->valueType) {
            'string' => strcmp((string)$a, (string)$b),
            default => $a <=> $b,
        };
    }
}
