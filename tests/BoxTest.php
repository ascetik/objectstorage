<?php

declare(strict_types=1);

namespace Ascetik\Storage\Tests;

use Ascetik\ObjectStorage\Container\Box;
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

    public function testBoxContent()
    {
        $essai1 = new FakeInstance('one');
        $essai2 = new FakeInstance('two');
        $essai3 = clone $essai1;
        $this->storage->set($essai1);
        $this->storage->set($essai2);
        $this->assertCount(2, $this->storage);
        $this->assertTrue($this->storage->contains($essai1));
        $this->assertFalse($this->storage->contains(new stdClass()));
        $this->assertTrue($this->storage->hasAny($essai3));
    }
/*
    public function testRemoveSomeContent()
    {
        $this->storage->set(new FakeInstance('test'));
        $this->storage->set(new FakeInstance('essai'));
        $this->storage->set(new FakeInstance('another try'));
        $this->assertCount(3, $this->storage);

        $this->assertTrue($this->storage->remove(fn(FakeInstance $instance) => $instance->name == 'essai'));
        // $this->assertFalse($this->storage->remove(new Essai('portnaouak')));
        $this->assertCount(2, $this->storage);
    }

    public function testGetFirstElementFromStorage()
    {
        $this->storage->attach(new Essai('test'));
        $this->storage->attach(new Essai('essai'));
        $shifted = $this->storage->shift();

        $this->assertInstanceOf(Essai::class, $shifted);
        $this->assertSame('test', $shifted->name);
    }

    public function testGetLastElementFromStorage()
    {
        $this->storage->attach(new Essai('test'));
        $this->storage->attach(new Essai('another try'));
        $this->storage->attach(new Essai('essai'));
        $poped = $this->storage->pop();

        $this->assertInstanceOf(Essai::class, $poped);
        $this->assertSame('essai', $poped->name);
    }

    public function testGetAnyElementFromStorage()
    {
        $this->storage->attach(new Essai('test premier'));
        $this->storage->attach(new Essai('essai'));
        $this->storage->attach(new Essai('another test'));
        $found = $this->storage->find(
            fn (Essai $essai) => str_contains($essai->name, 'essai')
        );

        $this->assertInstanceOf(Essai::class, $found);
        $this->assertSame('essai', $found->name);
    }

    public function testFilteredElementsFromStorage()
    {
        $this->storage->attach(new Essai('test premier'));
        $this->storage->attach(new Essai('essai'));
        $this->storage->attach(new Essai('another test'));
        $found = $this->storage->filter(
            fn (Essai $essai) => str_contains($essai->name, 'test')
        );

        $this->assertInstanceOf(Box::class, $found);
        $this->assertCount(2, $found);
    }

    public function testDoSomethingWithEachElement()
    {
        $results = [];
        $this->storage->attach(new Essai('test premier'));
        $this->storage->attach(new Essai('essai'));
        $this->storage->attach(new Essai('another test'));
        $this->storage->each(
            function (Essai $essai) use (&$results) {
                $results[] = $essai->capitalize();
            }
        );
        $expected = [
            'Test Premier',
            'Essai',
            'Another Test'
        ];
        $this->assertSame($expected, $results);
    }

    public function testGetArrayFromBox()
    {
        $essai1 = new Essai('test premier');
        $essai2 = new Essai('essai');
        $essai3 = new Essai('another test');
        $this->storage->attach($essai1);
        $this->storage->attach($essai2);
        $this->storage->attach($essai3);
        $expected = [$essai1, $essai2, $essai3];
        $this->assertSame($expected, $this->storage->toArray());
    }
    */
}
