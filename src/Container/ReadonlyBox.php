<?php

/**
 * This is part of the Ascetik objectstorage package
 *
 * @package    ObjectStorage
 * @category   Container
 * @license    https://opensource.org/license/mit/  MIT License
 * @copyright  Copyright (c) 2023, Vidda
 * @author     Vidda <vidda@ascetik.fr>
 */

declare(strict_types=1);

namespace Ascetik\ObjectStorage\Container;

use Ascetik\ObjectStorage\Traits\ReadableContainer;
use SplObjectStorage;

/**
 * @version 1.0.0
 */
class ReadonlyBox implements \Countable, \IteratorAggregate
{
    use ReadableContainer;

    public function __construct(private SplObjectStorage $container)
    {
    }
}
