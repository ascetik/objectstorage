<?php

namespace Ascetik\ObjectStorage\Results;

use Ascetik\ObjectStorage\Types\ComparisonResult;

class DescendingResult extends ComparisonResult
{
    public function reversed(): bool
    {
        return $this->result >= 0;

    }
}
