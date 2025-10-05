<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Assert;
use Sif\SortedLinkedList\SortedLinkedList;

class SortedLinkedListTest extends TestCase
{
    /**
     * @return array<string, array{mixed, string}>
     */
    public static function invalidValueProvider(): array
    {
        return [
          'null value' => [null, 'null'],
          'float value' => [3.14, 'float'],
          'array value' => [[1, 2, 3], 'array'],
          'object value' => [new \stdClass(), 'stdClass'],
          'boolean true' => [true, 'bool'],
          'boolean false' => [false, 'bool'],
        ];
    }

    /**
     * @dataProvider invalidValueProvider
     */
    public function testInvalidValueRejected(mixed $invalidValue, string $expectedType): void
    {
        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage("must be of type string|int, $expectedType given");

        $list = new SortedLinkedList();
        $list->insert($invalidValue); // @phpstan-ignore argument.type
    }

    public function testInsertSingleElement(): void
    {
        $list = new SortedLinkedList();
        $list->insert(5);

        Assert::assertSame(1, $list->count());
        Assert::assertFalse($list->isEmpty());
    }

    public function testInsertMultipleInOrder(): void
    {
        $list = new SortedLinkedList();
        $list->insert(1)->insert(2)->insert(3);

        Assert::assertSame(3, $list->count());
    }

    public function testInsertReverseOrder(): void
    {
        $list = new SortedLinkedList();
        $list->insert(3)->insert(2)->insert(1);

        Assert::assertSame(3, $list->count());
    }

    public function testInsertWithDuplicates(): void
    {
        $list = new SortedLinkedList();
        $list->insert(5)->insert(5)->insert(5);

        Assert::assertSame(3, $list->count());
    }

    public function testTypeConsistency(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot insert string into list of int');

        $list = new SortedLinkedList();
        $list->insert(1);
        $list->insert('string');
    }

    public function testEmptyListAcceptsFirstType(): void
    {
        $list = new SortedLinkedList();
        $list->insert('string');

        Assert::assertSame(1, $list->count());
    }

    public function testInsertChaining(): void
    {
        $list = new SortedLinkedList();
        $result = $list->insert(1)->insert(2)->insert(3);

        Assert::assertSame($list, $result);
    }
}
