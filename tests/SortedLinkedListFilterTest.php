<?php

declare(strict_types=1);

namespace Sif\SortedLinkedList\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Assert;
use Sif\SortedLinkedList\SortedLinkedList;

class SortedLinkedListFilterTest extends TestCase
{
    public function testFilterWithIntegers(): void
    {
        $list = SortedLinkedList::fromArray([1, 2, 3, 4, 5, 6]);
        $filtered = $list->filter(fn ($x) => $x > 3);

        Assert::assertEquals([4, 5, 6], $filtered->toArray());
        Assert::assertCount(3, $filtered);
    }

    public function testFilterWithStrings(): void
    {
        /** @var SortedLinkedList<string> $list */
        $list = SortedLinkedList::fromArray(['apple', 'banana', 'cherry', 'date']);
        $filtered = $list->filter(fn ($s) => strlen($s) > 5);

        Assert::assertEquals(['banana', 'cherry'], $filtered->toArray());
        Assert::assertCount(2, $filtered);
    }

    public function testFilterMatchesAll(): void
    {
        $list = SortedLinkedList::fromArray([1, 2, 3, 4, 5]);
        $filtered = $list->filter(fn ($x) => $x >= 1);

        Assert::assertEquals($list->toArray(), $filtered->toArray());
        Assert::assertCount(5, $filtered);
    }

    public function testFilterMatchesNone(): void
    {
        $list = SortedLinkedList::fromArray([1, 2, 3, 4, 5]);
        $filtered = $list->filter(fn ($x) => $x > 100);

        Assert::assertTrue($filtered->isEmpty());
        Assert::assertCount(0, $filtered);
        Assert::assertEquals([], $filtered->toArray());
    }

    public function testFilterEmptyList(): void
    {
        $list = new SortedLinkedList();
        $filtered = $list->filter(fn ($x) => $x > 5);

        Assert::assertTrue($filtered->isEmpty());
        Assert::assertCount(0, $filtered);
    }

    public function testFilterMaintainsSortedOrder(): void
    {
        /** @var SortedLinkedList<int> $list */
        $list = SortedLinkedList::fromArray([5, 1, 9, 3, 7, 2, 8, 4, 6]);
        $filtered = $list->filter(fn ($x) => $x % 2 === 0);

        Assert::assertEquals([2, 4, 6, 8], $filtered->toArray());
    }

    public function testFilterWithComplexPredicate(): void
    {
        $list = SortedLinkedList::fromArray([10, 20, 30, 40, 50, 60]);
        $filtered = $list->filter(fn ($x) => $x >= 20 && $x <= 50);

        Assert::assertEquals([20, 30, 40, 50], $filtered->toArray());
    }

    public function testFilterDoesNotModifyOriginal(): void
    {
        $list = SortedLinkedList::fromArray([1, 2, 3, 4, 5]);
        $original = $list->toArray();

        $list->filter(fn ($x) => $x > 3);

        Assert::assertEquals($original, $list->toArray());
    }

    public function testFilteredListIsIndependent(): void
    {
        $list = SortedLinkedList::fromArray([1, 2, 3, 4, 5]);
        $filtered = $list->filter(fn ($x) => $x > 2);

        Assert::assertNotSame($list->getHead(), $filtered->getHead());
        Assert::assertNotSame($list, $filtered);
    }

    public function testFilterStringsWithSubstring(): void
    {
        /** @var SortedLinkedList<string> $list */
        $list = SortedLinkedList::fromArray(['apple', 'application', 'apricot', 'banana']);
        $filtered = $list->filter(fn ($s) => str_contains($s, 'app'));

        Assert::assertEquals(['apple', 'application'], $filtered->toArray());
    }

    public function testFilterPreservesValueType(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        /** @var SortedLinkedList<int> $list */
        $list = SortedLinkedList::fromArray([1, 2, 3, 4, 5]);
        $filtered = $list->filter(fn ($x) => $x % 2 === 0);
        $filtered->insert('string'); // @phpstan-ignore argument.type
    }
}
