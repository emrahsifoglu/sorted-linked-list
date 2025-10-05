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

    public function testDeleteHead(): void
    {
        $list = new SortedLinkedList();
        $list->insert(1)->insert(2)->insert(3);

        Assert::assertTrue($list->delete(1));
        Assert::assertSame(2, $list->getSize());
        Assert::assertFalse($list->search(1));
    }

    public function testDeleteMiddle(): void
    {
        $list = new SortedLinkedList();
        $list->insert(1)->insert(2)->insert(3);
        $list->delete(2);

        Assert::assertSame(2, $list->getSize());
        Assert::assertFalse($list->search(2));
    }

    public function testDeleteTail(): void
    {
        $list = new SortedLinkedList();
        $list->insert(1)->insert(2)->insert(3);
        $list->delete(3);

        Assert::assertSame(2, $list->getSize());
        Assert::assertFalse($list->search(3));
    }

    public function testDeleteNonExistent(): void
    {
        $list = new SortedLinkedList();
        $list->insert(1)->insert(2);
        $list->delete(99);

        Assert::assertFalse($list->delete(99));
        Assert::assertSame(2, $list->getSize());
    }

    public function testDeleteFirstDuplicate(): void
    {
        $list = new SortedLinkedList();
        $list->insert(5)->insert(5)->insert(5);

        Assert::assertTrue($list->delete(5));
        Assert::assertSame(2, $list->getSize());
        Assert::assertTrue($list->search(5));
    }

    public function testDeleteNonExistentMiddle(): void
    {
        $list = new SortedLinkedList();
        $list->insert(1)->insert(5)->insert(9);

        Assert::assertFalse($list->delete(3));
        Assert::assertSame(3, $list->getSize());
    }
}
