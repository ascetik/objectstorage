<?php

namespace Ascetik\ObjectStorage\Values;

use Ascetik\ObjectStorage\Types\ComparisonResult;

class AscendingResult extends ComparisonResult
{
    public function reversed(): bool
    {
        return $this->result < 0;

    }
}
