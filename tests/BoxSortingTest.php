<?php

namespace Ascetik\ObjectStorage\Tests;

use Ascetik\ObjectStorage\Enums\BoxSortOrder;
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

    public function testOrderEnumResult()
    {
        $asc = BoxSortOrder::ASC;
        $this->assertInstanceOf(AscendingResult::class, $asc->result(0));
        $desc = BoxSortOrder::DESC;
        $this->assertInstanceOf(DescendingResult::class, $desc->result(1));
    }
}
