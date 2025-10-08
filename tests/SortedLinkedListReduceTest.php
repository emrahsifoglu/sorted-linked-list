<?php

declare(strict_types=1);

namespace Sif\SortedLinkedList\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Assert;
use Sif\SortedLinkedList\SortedLinkedList;

class SortedLinkedListReduceTest extends TestCase
{
    public function testReduceWithIntegersAndInitial(): void
    {
        /** @var SortedLinkedList<int> $list */
        $list = SortedLinkedList::fromArray([1, 2, 3, 4, 5]);
        $result = $list->reduce(fn ($carry, $item) => $carry + $item, 0);

        Assert::assertEquals(15, $result);
    }

    public function testReduceWithIntegersWithoutInitial(): void
    {
        /** @var SortedLinkedList<int> $list */
        $list = SortedLinkedList::fromArray([1, 2, 3, 4, 5]);
        $result = $list->reduce(fn ($carry, $item) => $carry + $item);

        Assert::assertEquals(15, $result);
    }

    public function testReduceWithStringsConcatenation(): void
    {
        /** @var SortedLinkedList<string> $list */
        $list = SortedLinkedList::fromArray(['a', 'b', 'c']);
        $result = $list->reduce(fn ($carry, $item) => $carry . $item, '');

        Assert::assertEquals('abc', $result);
    }

    public function testReduceWithStringsWithoutInitial(): void
    {
        /** @var SortedLinkedList<string> $list */
        $list = SortedLinkedList::fromArray(['Hello', 'World']);
        $result = $list->reduce(fn ($carry, $item) => $carry . ' ' . $item);

        Assert::assertEquals('Hello World', $result);
    }

    public function testReduceReturnsInteger(): void
    {
        /** @var SortedLinkedList<int> $list */
        $list = SortedLinkedList::fromArray([10, 20, 30]);
        $result = $list->reduce(fn ($carry, $item) => $carry + $item, 0);

        Assert::assertIsInt($result);
        Assert::assertEquals(60, $result);
    }

    public function testReduceReturnsString(): void
    {
        /** @var SortedLinkedList<int> $list */
        $list = SortedLinkedList::fromArray([1, 2, 3]);
        $result = $list->reduce(fn ($carry, $item) => $carry . $item, '');

        Assert::assertIsString($result);
        Assert::assertEquals('123', $result);
    }

    public function testReduceWithMultiplication(): void
    {
        /** @var SortedLinkedList<int> $list */
        $list = SortedLinkedList::fromArray([2, 3, 4]);
        $result = $list->reduce(fn ($carry, $item) => $carry * $item, 1);

        Assert::assertEquals(24, $result);
    }

    public function testReduceWithMaximum(): void
    {
        /** @var SortedLinkedList<int> $list */
        $list = SortedLinkedList::fromArray([5, 1, 9, 3, 7]);
        $result = $list->reduce(fn ($carry, $item) => max($carry, $item), 0);

        Assert::assertEquals(9, $result);
    }

    public function testReduceWithSingleElementAndInitial(): void
    {
        /** @var SortedLinkedList<int> $list */
        $list = SortedLinkedList::fromArray([42]);
        $result = $list->reduce(fn ($carry, $item) => $carry + $item, 8);

        Assert::assertEquals(50, $result);
    }

    public function testReduceWithSingleElementWithoutInitial(): void
    {
        /** @var SortedLinkedList<int> $list */
        $list = SortedLinkedList::fromArray([42]);
        $result = $list->reduce(fn ($carry, $item) => $carry + $item);

        Assert::assertEquals(42, $result);
    }

    public function testReduceEmptyListWithInitial(): void
    {
        $list = new SortedLinkedList();
        $result = $list->reduce(fn ($carry, $item) => $carry +  (int)$item, 100);

        Assert::assertEquals(100, $result);
    }

    public function testReduceEmptyListWithoutInitial(): void
    {
        $list = new SortedLinkedList();
        $result = $list->reduce(fn ($carry, $item) => $carry + (int)$item);

        Assert::assertNull($result);
    }

    public function testReduceWithArrayBuilding(): void
    {
        /** @var SortedLinkedList<int> $list */
        $list = SortedLinkedList::fromArray([1, 2, 3, 4, 5]);
        $result = $list->reduce(function ($carry, $item) {
            assert(is_array($carry));
            $carry[] = $item * 2;
            return $carry;
        }, []);

        Assert::assertEquals([2, 4, 6, 8, 10], $result);
    }

    public function testReduceWithFiltering(): void
    {
        /** @var SortedLinkedList<int> $list */
        $list = SortedLinkedList::fromArray([1, 2, 3, 4, 5, 6]);
        $result = $list->reduce(function ($carry, $item) {
            if ($item % 2 === 0) {
                $carry++;
            }
            return $carry;
        }, 0);

        Assert::assertEquals(3, $result);
    }

    public function testReduceWithDifferentInitialValues(): void
    {
        /** @var SortedLinkedList<int> $list */
        $list = SortedLinkedList::fromArray([1, 2, 3]);
        $result1 = $list->reduce(fn ($carry, $item) => $carry + $item, 0);
        $result2 = $list->reduce(fn ($carry, $item) => $carry + $item, 10);

        Assert::assertEquals(6, $result1);
        Assert::assertEquals(16, $result2);
    }

    public function testReduceDoesNotModifyOriginal(): void
    {
        /** @var SortedLinkedList<int> $list */
        $list = SortedLinkedList::fromArray([1, 2, 3, 4, 5]);
        $original = $list->toArray();
        $list->reduce(fn ($carry, $item) => $carry + $item, 0);

        Assert::assertEquals($original, $list->toArray());
    }
}
