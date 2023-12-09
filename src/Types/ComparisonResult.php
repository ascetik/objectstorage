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

/**
 * @abstract
 * @version 1.0.0
 */
abstract class ComparisonResult
{
    public function __construct(
        protected int $result,
    ) {
    }

    abstract public function reversed(): bool;
}
