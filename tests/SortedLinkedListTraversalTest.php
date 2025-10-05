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
}
