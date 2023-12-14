<?php

declare(strict_types=1);

namespace Ascetik\ObjectStorage\Traits;

use Closure;
use SplObjectStorage;

trait ReadableBox
{
    private SplObjectStorage $container;

    public function toArray(): array
    {
        return iterator_to_array($this->container);
    }

    public function count(): int
    {
        return $this->container->count();
    }

    public function isEmpty(): bool
    {
        return $this->container->count() == 0;
    }

    public function contains(object $instance)
    {
        return $this->container->contains($instance);
    }

    public function hasAny(object $instance)
    {
        foreach ($this->container as $content) {
            if ($instance == $content) {
                return true;
            }
        }
        return false;
    }

    public function first(): ?object
    {
        if ($this->isEmpty()) {
            return null;
        }
        $this->container->rewind();
        return $this->container->current();
    }

    public function last(): ?object
    {
        if ($this->isEmpty()) {
            return null;
        }
        $this->container->rewind();
        while ($this->container->valid()) {
            $next = $this->container->current();
            $this->container->next();
        }
        return $next;
    }

    public function find(Closure $closure): ?object
    {
        foreach ($this->container as $content) {
            $result = call_user_func($closure, $content);
            if ($result) {
                return $content;
            }
        }
        return null;
    }

    public function findByOffset(Closure $closure): ?object
    {
        foreach ($this->container as $content) {
            $offset = $this->container->offsetGet($content);
            $result = call_user_func($closure, $offset);
            if ($result) {
                return $content;
            }
        }
        return null;
    }

    public function each(Closure $closure): void
    {
        foreach ($this->container as $content) {
            call_user_func($closure, $content);
        }
    }

    public function getIterator(): SplObjectStorage
    {
        return $this->container;
    }

}
