<?php

namespace Ascetik\ObjectStorage\Types;

abstract class ComparisonResult
{
    public function __construct(
        protected int $result,
    ) {
    }

    abstract public function reversed(): bool;

}
