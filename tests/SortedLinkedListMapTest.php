<?php

declare(strict_types=1);

namespace Sif\SortedLinkedList\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Assert;
use Sif\SortedLinkedList\SortedLinkedList;

class SortedLinkedListMapTest extends TestCase
{
    public function testMapWithIntegersDoubling(): void
    {
        $list = SortedLinkedList::fromArray([1, 2, 3, 4, 5]);
        $mapped = $list->map(fn ($x) => $x * 2);

        Assert::assertEquals([2, 4, 6, 8, 10], $mapped->toArray());
        Assert::assertCount(5, $mapped);
    }

    public function testMapWithIntegersSquaring(): void
    {
        $list = SortedLinkedList::fromArray([1, 2, 3, 4]);
        $mapped = $list->map(fn ($x) => $x * $x);

        Assert::assertEquals([1, 4, 9, 16], $mapped->toArray());
    }

    public function testMapWithStringsToUppercase(): void
    {
        $list = SortedLinkedList::fromArray(['apple', 'banana', 'cherry']);
        $mapped = $list->map(fn ($s) => strtoupper($s));

        Assert::assertEquals(['APPLE', 'BANANA', 'CHERRY'], $mapped->toArray());
    }

    public function testMapWithStringsLength(): void
    {
        $list = SortedLinkedList::fromArray(['a', 'bb', 'ccc']);
        $mapped = $list->map(fn ($s) => strlen($s));

        Assert::assertEquals([1, 2, 3], $mapped->toArray());
    }

    public function testMapMaintainsSortedOrder(): void
    {
        $list = SortedLinkedList::fromArray([5, 1, 3, 2, 4]);
        $mapped = $list->map(fn ($x) => $x * 10);

        Assert::assertEquals([10, 20, 30, 40, 50], $mapped->toArray());
    }

    public function testMapWithNegativeValues(): void
    {
        $list = SortedLinkedList::fromArray([1, 2, 3]);
        $mapped = $list->map(fn ($x) => -$x);

        Assert::assertEquals([-3, -2, -1], $mapped->toArray());
    }

    public function testMapEmptyList(): void
    {
        $list = new SortedLinkedList();
        $mapped = $list->map(fn ($x) => $x * 2);

        Assert::assertTrue($mapped->isEmpty());
        Assert::assertCount(0, $mapped);
    }

    public function testMapDoesNotModifyOriginal(): void
    {
        $list = SortedLinkedList::fromArray([1, 2, 3, 4, 5]);
        $original = $list->toArray();

        $list->map(fn ($x) => $x * 2);

        Assert::assertEquals($original, $list->toArray());
    }

    public function testMappedListIsIndependent(): void
    {
        $list = SortedLinkedList::fromArray([1, 2, 3]);
        $mapped = $list->map(fn ($x) => $x + 1);

        Assert::assertNotSame($list->getHead(), $mapped->getHead());
        Assert::assertNotSame($list, $mapped);
    }

    public function testMapWithSingleElement(): void
    {
        $list = SortedLinkedList::fromArray([42]);
        $mapped = $list->map(fn ($x) => $x / 2);

        Assert::assertEquals([21], $mapped->toArray());
    }

    public function testMapChangesType(): void
    {
        $list = SortedLinkedList::fromArray([1, 2, 3]);
        $mapped = $list->map(fn ($x) => (string)$x);

        Assert::assertEquals(['1', '2', '3'], $mapped->toArray());
    }

    public function testMapWithComplexTransformation(): void
    {
        $list = SortedLinkedList::fromArray([1, 2, 3, 4, 5]);
        $mapped = $list->map(fn ($x) => $x * 2 + 1);

        Assert::assertEquals([3, 5, 7, 9, 11], $mapped->toArray());
    }

    public function testMapResortsElements(): void
    {
        $list = SortedLinkedList::fromArray([1, 2, 3]);
        $mapped = $list->map(fn ($x) => 10 - $x);

        Assert::assertEquals([7, 8, 9], $mapped->toArray());
    }

    public function testMapWithStringConcatenation(): void
    {
        $list = SortedLinkedList::fromArray(['a', 'b', 'c']);
        $mapped = $list->map(fn ($s) => $s . 'x');

        Assert::assertEquals(['ax', 'bx', 'cx'], $mapped->toArray());
    }

    public function testMapThrowsOnMixedTypes(): void
    {
        $list = SortedLinkedList::fromArray([1, 2, 3]);

        $this->expectException(\InvalidArgumentException::class);
        $list->map(fn ($x) => $x === 2 ? 'string' : $x);
    }
}
