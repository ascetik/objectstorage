<?php

namespace Ascetik\ObjectStorage\Traits;

trait ReadableContainer
{
    private \SplObjectStorage $container;

    public function toArray(): array
    {
        $output = [];
        foreach ($this->container as $content) {
            $output[] = $content;
        }
        return $output;
    }

}
