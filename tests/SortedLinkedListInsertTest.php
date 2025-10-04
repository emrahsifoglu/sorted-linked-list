<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Assert;
use Sif\SortedLinkedList\SortedLinkedList;

class SortedLinkedListInsertTest extends TestCase
{
    public function testSimpleNumberSorting(): void
    {
        $list = new SortedLinkedList();
        $list->insert(42);
        $list->insert(5);
        $list->insert(100);

        $firstNode = $list->getHead();
        Assert::assertNotNull($firstNode);

        $secondNode = $firstNode->getNext();
        Assert::assertNotNull($secondNode);

        $thirdNode = $secondNode->getNext();
        Assert::assertNotNull($thirdNode);

        Assert::assertNull($thirdNode->getNext());
        Assert::assertSame(5, $firstNode->getValue());
        Assert::assertSame(42, $secondNode->getValue());
        Assert::assertSame(100, $thirdNode->getValue());
    }

    public function testNumberInsertionWithDuplicates(): void
    {
        $list = new SortedLinkedList();
        $list->insert(10);
        $list->insert(20);
        $list->insert(10);

        $firstNode = $list->getHead();
        Assert::assertNotNull($firstNode);

        $secondNode = $firstNode->getNext();
        Assert::assertNotNull($secondNode);

        $thirdNode = $secondNode->getNext();
        Assert::assertNotNull($thirdNode);

        Assert::assertNull($thirdNode->getNext());
        Assert::assertSame(10, $firstNode->getValue());
        Assert::assertSame(10, $secondNode->getValue());
        Assert::assertSame(20, $thirdNode->getValue());
    }

    public function testNumberInsertionEdgeCase(): void
    {
        $list = new SortedLinkedList();
        $list->insert(50);
        $list->insert(25);

        $firstNode = $list->getHead();
        Assert::assertNotNull($firstNode);

        $secondNode = $firstNode->getNext();
        Assert::assertNotNull($secondNode);

        Assert::assertNull($secondNode->getNext());
        Assert::assertSame(25, $firstNode->getValue());
        Assert::assertSame(50, $secondNode->getValue());
    }

    public function testComplexNumberInsertion(): void
    {
        $list = new SortedLinkedList();
        $list->insert(10);
        $list->insert(50);
        $list->insert(5);
        $list->insert(10);
        $list->insert(50);

        /** @var \Sif\SortedLinkedList\Node<int> $firstNode */
        $firstNode = $list->getHead();
        /** @var \Sif\SortedLinkedList\Node<int> $secondNode */
        $secondNode = $firstNode->getNext();
        /** @var \Sif\SortedLinkedList\Node<int> $thirdNode */
        $thirdNode = $secondNode->getNext();
        /** @var \Sif\SortedLinkedList\Node<int> $fourthNode */
        $fourthNode = $thirdNode->getNext();
        /** @var \Sif\SortedLinkedList\Node<int> $fifthNode */
        $fifthNode = $fourthNode->getNext();

        Assert::assertSame(5, $firstNode->getValue());
        Assert::assertSame(10, $secondNode->getValue());
        Assert::assertSame(10, $thirdNode->getValue());
        Assert::assertSame(50, $fourthNode->getValue());
        Assert::assertSame(50, $fifthNode->getValue());
    }

    public function testSimpleStringSorting(): void
    {
        $list = new SortedLinkedList();
        $list->insert('zebra');
        $list->insert('cat');
        $list->insert('apple');

        $firstNode = $list->getHead();
        Assert::assertNotNull($firstNode);

        $secondNode = $firstNode->getNext();
        Assert::assertNotNull($secondNode);

        $thirdNode = $secondNode->getNext();
        Assert::assertNotNull($thirdNode);

        Assert::assertNull($thirdNode->getNext());
        Assert::assertSame('apple', $firstNode->getValue());
        Assert::assertSame('cat', $secondNode->getValue());
        Assert::assertSame('zebra', $thirdNode->getValue());
    }

    public function testStringInsertionWithDuplicates(): void
    {
        $list = new SortedLinkedList();
        $list->insert('apple');
        $list->insert('banana');
        $list->insert('apple');

        $firstNode = $list->getHead();
        Assert::assertNotNull($firstNode);

        $secondNode = $firstNode->getNext();
        Assert::assertNotNull($secondNode);

        $thirdNode = $secondNode->getNext();
        Assert::assertNotNull($thirdNode);

        Assert::assertNull($thirdNode->getNext());
        Assert::assertSame('apple', $firstNode->getValue());
        Assert::assertSame('apple', $secondNode->getValue());
        Assert::assertSame('banana', $thirdNode->getValue());
    }

    public function testInsertionToEmptyListAndNextElement(): void
    {
        $list = new SortedLinkedList();
        $list->insert('dog');
        $list->insert('cat');

        $firstNode = $list->getHead();
        Assert::assertNotNull($firstNode);

        $secondNode = $firstNode->getNext();
        Assert::assertNotNull($secondNode);

        Assert::assertNull($secondNode->getNext());
        Assert::assertSame('cat', $firstNode->getValue());
        Assert::assertSame('dog', $secondNode->getValue());
    }
}
