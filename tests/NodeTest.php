<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Assert;
use Sif\SortedLinkedList\Node;

class NodeTest extends TestCase
{
    public function testSetValue(): void
    {
        $node = new Node(42);
        $node->setValue(100);

        Assert::assertSame(100, $node->getValue());
    }

    public function testConstructorWithIntValue(): void
    {
        $node = new Node(42);

        Assert::assertSame(42, $node->getValue());
        Assert::assertNull($node->getNext());
    }

    public function testConstructorWithStringValue(): void
    {
        $node = new Node('hello');

        Assert::assertSame('hello', $node->getValue());
        Assert::assertNull($node->getNext());
    }

    public function testConstructorWithNext(): void
    {
        $next = new Node(20);
        $node = new Node(10, $next);

        Assert::assertSame(10, $node->getValue());
        Assert::assertSame($next, $node->getNext());
    }

    public function testNodeChaining(): void
    {
        $third = new Node(3);
        $second = new Node(2, $third);
        $first = new Node(1, $second);

        Assert::assertSame(1, $first->getValue());
        Assert::assertSame(2, $first->getNext()?->getValue());
        Assert::assertSame(3, $first->getNext()->getNext()?->getValue());
    }
}
