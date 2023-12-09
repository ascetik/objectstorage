<?php

namespace Ascetik\ObjectStorage\Tests;

use Ascetik\ObjectStorage\DTO\ItemComparator;
use Ascetik\ObjectStorage\Enums\BoxSortOrder;
use Ascetik\ObjectStorage\Tests\Mocks\Number;
use Ascetik\ObjectStorage\Types\ComparisonResult;
use Ascetik\ObjectStorage\Values\AscendingResult;
use Ascetik\ObjectStorage\Values\DescendingResult;
use PHPUnit\Framework\TestCase;

class BoxSortingTest extends TestCase
{
    public function testAscendingResult()
    {
        $result = new AscendingResult(1);
        $this->assertFalse($result->reversed());
    }

    public function testDescendingResult()
    {
        $result = new DescendingResult(-1);
        $this->assertFalse($result->reversed());
    }

    public function testComparisonResultFactory()
    {
        $asc = BoxSortOrder::ASC;
        $this->assertInstanceOf(AscendingResult::class, ComparisonResult::create($asc, 0));
        $desc = BoxSortOrder::DESC;
        $this->assertInstanceOf(DescendingResult::class, ComparisonResult::create($desc, 0));
    }

    public function testItemComparatorWithAscendingOrder()
    {
        $a = new Number(1);
        $b = new Number(2);
        $sorting = fn (Number $a, Number $b) => $a->value - $b->value;
        $comparator = new ItemComparator($sorting, BoxSortOrder::ASC);
        $this->assertTrue($comparator->compare($a, $b)->reversed());
    }

    public function testItemComparatorWithDescendingOrder()
    {
        $a = new Number(1);
        $b = new Number(2);
        $sorting = fn (Number $a, Number $b) => $a->value - $b->value;
        $comparator = new ItemComparator($sorting, BoxSortOrder::DESC);
        $this->assertFalse($comparator->compare($a, $b)->reversed());
    }
}
