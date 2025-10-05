<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Assert;
use Sif\SortedLinkedList\SortedLinkedList;

class SortedLinkedListDeleteTest extends TestCase
{
    public function testDeleteFromEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot delete in an empty list');

        $list = new SortedLinkedList();
        $list->delete(1);
    }

    public function testDeleteStringHead(): void
    {
        $list = new SortedLinkedList();
        $list->insert('test')->insert('apple')->insert('list');

        Assert::assertTrue($list->delete('apple'));
        Assert::assertSame(2, $list->count());
        Assert::assertFalse($list->search('apple'));
    }

    public function testDeleteIntHead(): void
    {
        $list = new SortedLinkedList();
        $list->insert(10)->insert(5)->insert(15);

        Assert::assertTrue($list->delete(5));
        Assert::assertCount(2, $list);
        Assert::assertFalse($list->search(5));

        $expected = [10, 15];
        $actual = [];

        foreach ($list as $value) {
            $actual[] = $value;
        }

        Assert::assertSame($expected, $actual);
    }

    public function testDeleteMiddle(): void
    {
        $list = new SortedLinkedList();
        $list->insert(1)->insert(2)->insert(3);
        $list->delete(2);

        Assert::assertSame(2, $list->count());
        Assert::assertFalse($list->search(2));
    }

    public function testDeleteStringTail(): void
    {
        $list = new SortedLinkedList();
        $list->insert('test')->insert('apple')->insert('list');
        $list->delete('test');

        Assert::assertSame(2, $list->count());
        Assert::assertFalse($list->search('test'));
    }

    public function testDeleteIntTail(): void
    {
        $list = new SortedLinkedList();
        $list->insert(10)->insert(5)->insert(15);

        Assert::assertTrue($list->delete(15));
        Assert::assertCount(2, $list);
        Assert::assertFalse($list->search(15));

        $expected = [5, 10];
        $actual = [];

        foreach ($list as $value) {
            $actual[] = $value;
        }

        Assert::assertSame($expected, $actual);
    }

    public function testDeleteNonExistent(): void
    {
        $list = new SortedLinkedList();
        $list->insert(1)->insert(2);
        $list->delete(99);

        Assert::assertFalse($list->delete(99));
        Assert::assertSame(2, $list->count());
    }

    public function testDeleteFirstDuplicate(): void
    {
        $list = new SortedLinkedList();
        $list->insert(5)->insert(5)->insert(5);

        Assert::assertTrue($list->delete(5));
        Assert::assertSame(2, $list->count());
        Assert::assertTrue($list->search(5));
    }

    public function testDeleteNonExistentMiddle(): void
    {
        $list = new SortedLinkedList();
        $list->insert(1)->insert(5)->insert(9);

        Assert::assertFalse($list->delete(3));
        Assert::assertSame(3, $list->count());
    }

    public function testDeleteMiddleElement(): void
    {
        $list = new SortedLinkedList();
        $list->insert(10)->insert(5)->insert(15);

        Assert::assertTrue($list->delete(10));
        Assert::assertCount(2, $list);
        Assert::assertFalse($list->search(10));

        $expected = [5, 15];
        $actual = [];

        foreach ($list as $value) {
            $actual[] = $value;
        }

        Assert::assertSame($expected, $actual);
    }

    public function testDeleteOnlyFirstOccurrenceOfDuplicate(): void
    {
        $list = new SortedLinkedList();
        $list->insert(10)->insert(5)->insert(10)->insert(15);

        Assert::assertTrue($list->delete(10));
        Assert::assertCount(3, $list);

        $expected = [5, 10, 15];
        $actual = [];

        foreach ($list as $value) {
            $actual[] = $value;
        }

        Assert::assertSame($expected, $actual);
        Assert::assertTrue($list->delete(10));
        Assert::assertCount(2, $list);
        Assert::assertFalse($list->search(10));
    }

    public function testDeleteUntilEmptyWithIteration(): void
    {
        $list = new SortedLinkedList();
        $list->insert(10)->insert(5)->insert(20);

        while ($list->count() > 0) {
            $head = $list->getHead();
            Assert::assertNotNull($head);

            $headValue = $head->getValue();
            Assert::assertTrue($list->delete($headValue));
        }

        Assert::assertCount(0, $list);
        Assert::assertTrue($list->isEmpty());
    }
}
