<?php

/**
 * This is part of the Ascetik objectstorage package
 *
 * @package    ObjectStorage
 * @category   Enum
 * @license    https://opensource.org/license/mit/  MIT License
 * @copyright  Copyright (c) 2023, Vidda
 * @author     Vidda <vidda@ascetik.fr>
 */

declare(strict_types=1);

namespace Ascetik\ObjectStorage\Types;

use Ascetik\ObjectStorage\Enums\BoxSortOrder;
use Ascetik\ObjectStorage\Results\AscendingResult;
use Ascetik\ObjectStorage\Results\DescendingResult;
use Exception;

/**
 * @abstract
 * @version 1.0.0
 */
abstract class ComparisonResult
{
    public function __construct(protected readonly int $result)
    {
    }

    abstract public function reversed(): bool;

    public static function create(BoxSortOrder $order, int $difference): self
    {
        return match ($order) {
            BoxSortOrder::ASC => new AscendingResult($difference),
            BoxSortOrder::DESC => new DescendingResult($difference),
            default => throw new Exception('unhandled order')
        };
    }
}
