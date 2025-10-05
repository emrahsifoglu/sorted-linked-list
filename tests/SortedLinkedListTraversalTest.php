<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Assert;
use Sif\SortedLinkedList\SortedLinkedList;

class SortedLinkedListTraversalTest extends TestCase
{
    public function testIterationOnEmptyList(): void
    {
        $list = new SortedLinkedList();
        $actual = [];

        foreach ($list as $value) {
            $actual[] = $value;
        }

        Assert::assertEmpty($actual);
    }

    public function testIterationAndKeys(): void
    {
        $list = new SortedLinkedList();
        $list->insert(30)->insert(10)->insert(20);

        $expectedValues = [10, 20, 30];
        $expectedKeys = [0, 1, 2];

        $actualValues = [];
        $actualKeys = [];

        foreach ($list as $key => $value) {
            $actualKeys[] = $key;
            $actualValues[] = $value;
        }

        Assert::assertSame($expectedValues, $actualValues);
        Assert::assertSame($expectedKeys, $actualKeys);
    }

    public function testToArrayEmpty(): void
    {
        $list = new SortedLinkedList();

        Assert::assertSame([], $list->toArray());
    }

    public function testToArrayPopulated(): void
    {
        $list = new SortedLinkedList();
        $list->insert(3)->insert(1)->insert(2);

        Assert::assertSame([1, 2, 3], $list->toArray());
    }

    public function testToArrayAfterModifications(): void
    {
        $list = new SortedLinkedList();
        $list->insert(1)->insert(2)->insert(3);
        $list->delete(2);

        Assert::assertSame([1, 3], $list->toArray());
    }

    public function testFromArrayEmpty(): void
    {
        $list = SortedLinkedList::fromArray([]);

        Assert::assertSame(0, count($list));
    }

    public function testFromArraySorted(): void
    {
        $list = SortedLinkedList::fromArray([1, 2, 3]);

        Assert::assertSame([1, 2, 3], $list->toArray());
    }

    public function testFromArrayUnsorted(): void
    {
        $list = SortedLinkedList::fromArray([3, 1, 2]);

        Assert::assertSame([1, 2, 3], $list->toArray());
    }

    public function testFromArrayDuplicates(): void
    {
        $list = SortedLinkedList::fromArray([2, 1, 2, 3]);

        Assert::assertSame([1, 2, 2, 3], $list->toArray());
    }

    public function testFromArrayMixedTypes(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Mixed types in array');

        SortedLinkedList::fromArray([1, 'string', 3]);
    }

    public function testFromArrayLarge(): void
    {
        $data = range(1, 100);

        shuffle($data);

        $list = SortedLinkedList::fromArray($data);

        Assert::assertSame(100, count($list));
        Assert::assertSame(range(1, 100), $list->toArray());
    }

    public function testFromArrayStringsSorted(): void
    {
        $list = SortedLinkedList::fromArray(['apple', 'banana', 'cherry']);

        Assert::assertSame(['apple', 'banana', 'cherry'], $list->toArray());
    }

    public function testFromArrayStringsUnsorted(): void
    {
        $list = SortedLinkedList::fromArray(['cherry', 'apple', 'banana']);

        Assert::assertSame(['apple', 'banana', 'cherry'], $list->toArray());
    }

    public function testFromArrayStringsDuplicates(): void
    {
        $list = SortedLinkedList::fromArray(['banana', 'apple', 'banana', 'cherry']);

        Assert::assertSame(['apple', 'banana', 'banana', 'cherry'], $list->toArray());
    }

    public function testFromArrayStringsLarge(): void
    {
        $data = ['apple', 'banana', 'cherry', 'date', 'elderberry', 'fig', 'grape'];
        shuffle($data);

        $list = SortedLinkedList::fromArray($data);

        $expected = ['apple', 'banana', 'cherry', 'date', 'elderberry', 'fig', 'grape'];
        sort($expected);

        Assert::assertSame(count($data), count($list));
        Assert::assertSame($expected, $list->toArray());
    }
}
