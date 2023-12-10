<?php

/**
 * This is part of the Ascetik objectstorage package
 *
 * @package    ObjectStorage
 * @category   Data Transfer Object
 * @license    https://opensource.org/license/mit/  MIT License
 * @copyright  Copyright (c) 2023, Vidda
 * @author     Vidda <vidda@ascetik.fr>
 */

 declare(strict_types=1);

namespace Ascetik\ObjectStorage\DTO;

use Ascetik\Callapsule\Factories\CallWrapper;
use Ascetik\Callapsule\Types\CallableType;
use Ascetik\ObjectStorage\Enums\BoxSortOrder;
use Ascetik\ObjectStorage\Types\ComparisonResult;

/**
 * @version 1.0.0
 */
class ItemComparator
{
    private CallableType $sorting;

    public function __construct(callable $sorter, private BoxSortOrder $order)
    {
        $this->sorting = CallWrapper::wrap($sorter);
    }

    public function compare(mixed $pivot, mixed $current): ComparisonResult
    {
        $compare = $this->sorting->apply([$pivot, $current]);
        return ComparisonResult::create($this->order,$compare);
    }
}
