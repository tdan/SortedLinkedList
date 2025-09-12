<?php

declare(strict_types=1);

namespace Tdan\SortedLinkedList\Tests;

use PHPUnit\Framework\TestCase;
use Tdan\SortedLinkedList\SortedLinkedList;

final class SortedLinkedListTest extends TestCase
{
    public function testCanConstruct(): void
    {
        $intList = new SortedLinkedList("integer");
        $this->assertInstanceOf(SortedLinkedList::class, $intList);

        $strList = new SortedLinkedList("string");
        $this->assertInstanceOf(SortedLinkedList::class, $strList);
    }

    public function testConstructInvalidType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Type must be either string or integer");
        new SortedLinkedList("invalidType");
    }

    public function testEmptyList(): void
    {
        $list = new SortedLinkedList("integer");

        $this->assertEquals(0, $list->size());
        $this->assertEquals("", $list->pop());
        $this->assertFalse($list->contains(10));

        $list->remove(10);
        $this->assertEquals([], $list->toArray());
    }

    public function testAddInt(): void
    {
        $list = new SortedLinkedList("integer");
        $list->add(10);
        $list->add(5);
        $list->add(20);
        $list->add(1);

        $this->assertEquals(4, $list->size());
        $this->assertEquals([1, 5, 10, 20], $list->toArray());
    }

    public function testAddIntDuplicate(): void
    {
        $list = new SortedLinkedList("integer");
        $list->add(10);
        $list->add(2);
        $list->add(10);
        $list->add(5);
        $list->add(20);
        $list->add(5);

        $this->assertEquals(6, $list->size());
        $this->assertEquals([2, 5, 5, 10, 10, 20], $list->toArray());
    }

    public function testAddString(): void
    {
        $list = new SortedLinkedList("string");
        $list->add("Symfony");
        $list->add("php8.3");
        $list->add("linux");
        $list->add("aweSome");

        $this->assertEquals(4, $list->size());
        $this->assertEquals(["Symfony", "aweSome", "linux", "php8.3"], $list->toArray());
    }

    public function testInvalidTypeException(): void
    {
        $list = new SortedLinkedList("string");
        $this->expectException(\InvalidArgumentException::class);
        $list->add(10);

        $newList = new SortedLinkedList("integer");
        $this->expectException(\InvalidArgumentException::class);
        $newList->add("10");
    }

    public function testContains(): void
    {
        $list = new SortedLinkedList("string");
        $list->add("Symfony");
        $list->add("php8.3");
        $list->add("linux");
        $list->add("aweSome");

        $this->assertTrue($list->contains("Symfony"));
        $this->assertTrue($list->contains("aweSome"));
        $this->assertTrue($list->contains("php8.3"));
        $this->assertFalse($list->contains("linux2"));
        $this->assertFalse($list->contains("Linux"));

        $this->expectException(\InvalidArgumentException::class);
        $list->contains(10);
    }

    public function testRemove(): void
    {
        $list = new SortedLinkedList("integer");
        $list->add(10);
        $list->add(5);
        $list->add(10);
        $list->add(20);
        $list->add(15);

        $list->remove(10);
        $this->assertEquals([5, 10, 15, 20], $list->toArray());

        $list->remove(5);
        $this->assertEquals([10, 15, 20], $list->toArray());

        $list->remove(6);
        $this->assertEquals([10, 15, 20], $list->toArray());

        $list->remove(20);
        $this->assertEquals([10, 15], $list->toArray());
    }

    public function testRemoveOneElementList(): void
    {
        $list = new SortedLinkedList("integer");
        $list->add(10);

        $list->remove(10);
        $this->assertEquals([], $list->toArray());
    }

    public function testClone(): void
    {
        $list = new SortedLinkedList("integer");
        $list->add(10);
        $list->add(5);
        $list->add(10);
        $list->add(20);
        $list->add(15);

        $clonedList = $list->clone();
        $this->assertEquals([5, 10, 10, 15, 20], $clonedList->toArray());
    }

    public function testCloneEmptyList(): void
    {
        $list = new SortedLinkedList("integer");
        $clonedList = $list->clone();
        $this->assertEquals([], $clonedList->toArray());
    }

    public function testIterator(): void
    {
        $list = new SortedLinkedList("integer");
        $list->add(10);
        $list->add(5);
        $list->add(10);
        $list->add(20);
        $list->add(15);

        $iterator = [];
        foreach ($list as $value) {
            $iterator[] = $value;
        }
        $this->assertEquals([5, 10, 10, 15, 20], $iterator);
    }
}
?>
