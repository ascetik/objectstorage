<?php

/**
 * This is part of the Ascetik objectstorage package
 *
 * @package    ObjectStorage
 * @category   Comparison Result Object
 * @license    https://opensource.org/license/mit/  MIT License
 * @copyright  Copyright (c) 2023, Vidda
 * @author     Vidda <vidda@ascetik.fr>
 */

declare(strict_types=1);

namespace Ascetik\ObjectStorage\Results;

use Ascetik\ObjectStorage\Types\ComparisonResult;

/**
 * @version 1.0.0
 */
class AscendingResult extends ComparisonResult
{
    public function reversed(): bool
    {
        return $this->result < 0;
    }
}
