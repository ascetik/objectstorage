<?php

declare(strict_types=1);

namespace Ascetik\Storage\Tests;

use Ascetik\ObjectStorage\Container\Box;
use Ascetik\ObjectStorage\Container\ReadonlyBox;
use Ascetik\ObjectStorage\Tests\Mocks\FakeInstance;
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
}
