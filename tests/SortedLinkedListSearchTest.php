<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Assert;
use Sif\SortedLinkedList\SortedLinkedList;

class SortedLinkedListSearchTest extends TestCase
{
    public function testSearchEmptyList(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot search in an empty list');

        $list = new SortedLinkedList();

        Assert::assertFalse($list->search(1));
    }

    public function testSearchHead(): void
    {
        $list = new SortedLinkedList();
        $list->insert(1)->insert(2)->insert(3);

        Assert::assertTrue($list->search(1));
    }

    public function testSearchExistingElement(): void
    {
        $list = new SortedLinkedList();
        $list->insert(1)->insert(2)->insert(3);

        Assert::assertTrue($list->search(2));
    }

    public function testSearchTail(): void
    {
        $list = new SortedLinkedList();
        $list->insert(1)->insert(2)->insert(3);

        Assert::assertTrue($list->search(3));
    }

    public function testSearchNonExistent(): void
    {
        $list = new SortedLinkedList();
        $list->insert(1)->insert(2)->insert(3);

        Assert::assertFalse($list->search(99));
    }

    public function testSearchWithDuplicates(): void
    {
        $list = new SortedLinkedList();
        $list->insert(5)->insert(5)->insert(5);

        Assert::assertTrue($list->search(5));
    }

    public function testSearchValidatesType(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $list = new SortedLinkedList();
        $list->insert(1);
        $list->search('string');
    }

    public function testSearchStringHead(): void
    {
        $list = new SortedLinkedList();
        $list->insert('zebra')->insert('apple')->insert('mango');

        Assert::assertTrue($list->search('apple'));
    }

    public function testSearchStringExistingElement(): void
    {
        $list = new SortedLinkedList();
        $list->insert('banana')->insert('apple')->insert('cherry');

        Assert::assertTrue($list->search('banana'));
    }

    public function testSearchStringTail(): void
    {
        $list = new SortedLinkedList();
        $list->insert('apple')->insert('banana')->insert('cherry');

        Assert::assertTrue($list->search('cherry'));
    }

    public function testSearchStringNonExistent(): void
    {
        $list = new SortedLinkedList();
        $list->insert('apple')->insert('banana')->insert('cherry');

        Assert::assertFalse($list->search('orange'));
    }

    public function testSearchStringWithDuplicates(): void
    {
        $list = new SortedLinkedList();
        $list->insert('apple')->insert('apple')->insert('apple');

        Assert::assertTrue($list->search('apple'));
    }

    public function testSearchStringValidatesType(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $list = new SortedLinkedList();
        $list->insert('apple');
        $list->search(123);
    }

    public function testSearchStringCaseSensitive(): void
    {
        $list = new SortedLinkedList();
        $list->insert('Apple')->insert('apple')->insert('APPLE');

        Assert::assertTrue($list->search('apple'));
        Assert::assertTrue($list->search('Apple'));
        Assert::assertTrue($list->search('APPLE'));
        Assert::assertFalse($list->search('aPpLe'));
    }

    public function testSearchEmptyString(): void
    {
        $list = new SortedLinkedList();
        $list->insert('')->insert('a')->insert('b');

        Assert::assertTrue($list->search(''));
    }

    public function testSearchStringWithSpaces(): void
    {
        $list = new SortedLinkedList();
        $list->insert('hello world');

        Assert::assertTrue($list->search('hello world'));
        Assert::assertFalse($list->search('helloworld'));
    }

    public function testSearchStringWithNumbers(): void
    {
        $list = new SortedLinkedList();
        $list->insert('test123')->insert('abc456')->insert('xyz789');

        Assert::assertTrue($list->search('test123'));
        Assert::assertFalse($list->search('test'));
    }

    public function testSearchStringWithSpecialCharacters(): void
    {
        $list = new SortedLinkedList();
        $list->insert('test@example.com')->insert('user-name')->insert('path/to/file');

        Assert::assertTrue($list->search('test@example.com'));
        Assert::assertTrue($list->search('user-name'));
        Assert::assertTrue($list->search('path/to/file'));
        Assert::assertFalse($list->search('test@example'));
    }

    public function testSearchUnicodeStrings(): void
    {
        $list = new SortedLinkedList();
        $list->insert('café')->insert('naïve')->insert('résumé');

        Assert::assertTrue($list->search('café'));
        Assert::assertTrue($list->search('naïve'));
        Assert::assertTrue($list->search('résumé'));
        Assert::assertFalse($list->search('cafe'));
        Assert::assertFalse($list->search('naive'));
        Assert::assertFalse($list->search('resume'));
    }
}
