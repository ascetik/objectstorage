<?php

namespace Ascetik\ObjectStorage\Container;

use Ascetik\ObjectStorage\Traits\ReadableContainer;
use SplObjectStorage;

class ReadonlyBox
{
    use ReadableContainer;

    public function __construct(private SplObjectStorage $container)
    {
        
    }
}
