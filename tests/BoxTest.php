<?php

declare(strict_types=1);

namespace Ascetik\Storage\Tests;

use Ascetik\ObjectStorage\Container\Box;
use Ascetik\ObjectStorage\Container\ReadonlyBox;
use Ascetik\ObjectStorage\Tests\Mocks\FakeInstance;
use Ascetik\ObjectStorage\Tests\Mocks\FakeOffset;
use PHPUnit\Framework\TestCase;
use stdClass;

class BoxTest extends TestCase
{
    private Box $storage;
    protected function setUp(): void
    {
        $this->storage = new Box();
    }

    public function testEmptyStorage()
    {
        $this->assertTrue($this->storage->isEmpty());
    }

    public function testPushingContent()
    {
        $essai1 = new FakeInstance('one');
        $essai2 = new FakeInstance('two');
        $essai3 = clone $essai1;
        $this->storage->push($essai1);
        $this->storage->push($essai2);
        $this->assertCount(2, $this->storage);
        $this->assertTrue($this->storage->contains($essai1));
        $this->assertFalse($this->storage->contains(new stdClass()));
        $this->assertTrue($this->storage->hasAny($essai3));
    }

    public function testRemoveSomeContent()
    {
        $this->storage->push(new FakeInstance('test'));
        $this->storage->push(new FakeInstance('essai'));
        $this->storage->push(new FakeInstance('another try'));
        $this->assertCount(3, $this->storage);

        $this->assertTrue($this->storage->remove(fn (FakeInstance $instance) => $instance->name == 'essai'));
        $this->assertFalse($this->storage->remove(fn (FakeInstance $instance) => $instance->name == 'something else'));
        $this->assertCount(2, $this->storage);
    }

    public function testGetFirstElementFromStorage()
    {
        $this->storage->push(new FakeInstance('test'));
        $this->storage->push(new FakeInstance('essai'));
        $this->assertCount(2, $this->storage);
        $shifted = $this->storage->first();

        // $this->assertInstanceOf(FakeInstance::class, $shifted);
        $this->assertSame('test', $shifted->name);
        // $this->assertCount(1, $this->storage);
    }

    public function testGetLastElementFromStorage()
    {
        $this->storage->push(new FakeInstance('test'));
        $this->storage->push(new FakeInstance('essai'));
        $shifted = $this->storage->last();
        $this->assertSame('essai', $shifted->name);
    }

    public function testUnshiftingContent()
    {
        $this->storage->push(new FakeInstance('second'));
        $this->storage->push(new FakeInstance('third'));
        $this->storage->unshift(new FakeInstance('first'));
        $this->assertSame('first', $this->storage->first()->name);
        $this->assertSame('third', $this->storage->last()->name);
    }

    public function testShouldShiftFirstElementFromStorage()
    {
        $this->storage->push(new FakeInstance('test'));
        $this->storage->push(new FakeInstance('essai'));
        $this->assertCount(2, $this->storage);
        $shifted = $this->storage->shift();
        $this->assertSame('test', $shifted->name);
        $this->assertCount(1, $this->storage);
    }

    public function testPopLastElementFromStorage()
    {
        $this->storage->push(new FakeInstance('test'));
        $this->storage->push(new FakeInstance('another try'));
        $this->storage->push(new FakeInstance('essai'));
        $poped = $this->storage->pop();

        $this->assertInstanceOf(FakeInstance::class, $poped);
        $this->assertSame('essai', $poped->name);
    }

    public function testGetAnyElementFromStorage()
    {
        $this->storage->push(new FakeInstance('test premier'));
        $this->storage->push(new FakeInstance('essai'));
        $this->storage->push(new FakeInstance('another test'));
        $found = $this->storage->find(
            fn (FakeInstance $essai) => str_contains($essai->name, 'essai')
        );

        $this->assertInstanceOf(FakeInstance::class, $found);
        $this->assertSame('essai', $found->name);
    }

    public function testFilteredElementsFromStorage()
    {
        $this->storage->push(new FakeInstance('test premier'));
        $this->storage->push(new FakeInstance('essai'));
        $this->storage->push(new FakeInstance('another test'));
        $found = $this->storage->filter(
            fn (FakeInstance $essai) => str_contains($essai->name, 'test')
        );

        $this->assertInstanceOf(Box::class, $found);
        $this->assertCount(2, $found);
    }

    public function testDoSomethingWithEachElement()
    {
        $results = [];
        $this->storage->push(new FakeInstance('test premier'));
        $this->storage->push(new FakeInstance('essai'));
        $this->storage->push(new FakeInstance('another test'));
        $this->storage->each(
            function (FakeInstance $essai) use (&$results) {
                $results[] = ucfirst($essai->name);
            }
        );
        $expected = [
            'Test premier',
            'Essai',
            'Another test'
        ];
        $this->assertSame($expected, $results);
    }

    public function testShouldReturnNewBoxOnMapCall()
    {
        $this->storage->push(new FakeInstance('test premier'));
        $this->storage->push(new FakeInstance('essai'));
        $this->storage->push(new FakeInstance('another test'));
        $mapped = $this->storage->map(
            fn (FakeInstance $essai) => new FakeInstance(strtoupper($essai->name))
        );

        $this->assertCount(3, $mapped->getIterator());
        $this->assertSame('TEST PREMIER', $mapped->shift()->name);
    }

    public function testGetArrayFromBox()
    {
        $essai1 = new FakeInstance('test premier');
        $essai2 = new FakeInstance('essai');
        $essai3 = new FakeInstance('another test');
        $this->storage->push($essai1);
        $this->storage->push($essai2);
        $this->storage->push($essai3);
        $expected = [$essai1, $essai2, $essai3];
        $this->assertSame($expected, $this->storage->toArray());
    }

    public function testSHouldBeAbleToReturnAREadonlyBox()
    {
        $this->assertInstanceOf(ReadonlyBox::class, $this->storage->readonly());
    }

    public function testShouldFindAnInstanceUsingItsOffset()
    {
        $essai1 = new FakeInstance('test premier');
        $essai2 = new FakeInstance('essai');
        $title1 = new FakeOffset('first');
        $title2 = new FakeOffset('second');
        $this->storage->push($essai1, $title1);
        $this->storage->push($essai2, $title2);

        $found = $this->storage->findByOffset(fn (FakeOffset $offset) => $offset->value == 'second');
        $this->assertSame('essai', $found->name);
        $notFound = $this->storage->findByOffset(fn (FakeOffset $offset) => $offset->value == 'third');
        $this->assertNull($notFound);
    }

    public function testShouldBeAbleToSetAnOffsetToAnElement()
    {
        $essai1 = new FakeInstance('test premier');
        $this->storage->push($essai1);
        $title1 = new FakeOffset('first');
        $this->storage->associate($essai1, $title1);
        $found = $this->storage->findByOffset(fn (FakeOffset $offset) => $offset->value == 'first');
        $this->assertSame('test premier', $found->name);
    }

    public function testShouldBeAbleToRetrieveAnOffsetFromABox()
    {
        $essai1 = new FakeInstance('test premier');
        $title1 = new FakeOffset('first');
        $this->storage->push($essai1, $title1);
        $result = $this->storage->valueOf($essai1);
        $this->assertSame($title1, $result);
    }

    public function testAssociateIgnoreMode()
    {
        $essai1 = new FakeInstance('test premier');
        // $this->storage->push($essai1);
        $title1 = new FakeOffset('first');
        $this->storage->associate($essai1, $title1);
        $this->assertEmpty($this->storage);
    }
    public function testAssociateAppendMode()
    {
        $essai1 = new FakeInstance('first test');
        $essai2 = new FakeInstance('second test');
        $title1 = new FakeOffset('first offset');
        $title2 = new FakeOffset('second offset');
        $this->storage->push($essai1, $title1);
        $this->storage->associate($essai2, $title2, $this->storage::APPEND_ON_MISSING);
        $last = $this->storage->last();
        $this->assertSame($last, $essai2);
        $this->assertSame('second offset',$this->storage->valueOf($last)->value);
    }

    public function testAssociatePrependMode()
    {
        $essai1 = new FakeInstance('first test');
        $essai2 = new FakeInstance('second test');
        $title1 = new FakeOffset('first offset');
        $title2 = new FakeOffset('second offset');
        $this->storage->push($essai1, $title1);
        $this->storage->associate($essai2, $title2, $this->storage::PREPEND_ON_MISSING);
        $first = $this->storage->first();
        $this->assertSame($first, $essai2);
        $this->assertSame('second offset',$this->storage->valueOf($first)->value);
    }

}
