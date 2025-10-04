<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Assert;
use Sif\SortedLinkedList\HelloWorld;

class HelloWorldTest extends TestCase
{
    public function testSayHelloReturnsCorrectString(): void
    {
        $helloWorld = new HelloWorld();
        Assert::assertSame('Hello, World!', $helloWorld->sayHello());
    }
}
