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
use Closure;
use SplObjectStorage;

class Box implements \Countable,  \IteratorAggregate
{
    use ReadableContainer;

    public function __construct()
    {
        $this->container = new SplObjectStorage();
    }

    public function push(object $instance, mixed $offset = null): void
    {
        $this->container->attach($instance, $offset);
    }

    public function unshift(object $instance, mixed $offset = null): void
    {
        $container = new SplObjectStorage();
        $container->attach($instance, $offset);
        $container->addAll($this->container);
        $this->container = $container;
    }

    public function shift(): ?object
    {
        if ($first = $this->first()) {
            $this->container->detach($first);
            return $first;
        }
        return null;
    }

    public function pop(): ?object
    {
        if ($last = $this->last()) {
            $this->container->detach($last);
            return $last;
        }
        return null;
    }

    public function remove(Closure $callback): bool
    {
        $content = $this->find($callback);
        if ($content) {
            $this->container->detach($content);
            return true;
        }
        return false;
    }

    public function filter(Closure $callback): self
    {
        $output = new self();
        foreach ($this->container as $content) {
            $result = call_user_func($callback, $content);
            if ($result) {
                $offset = $this->container->offsetGet($content);
                $output->push($content, $offset);
            }
        }
        return $output;
    }

    public function map(Closure $closure): self
    {
        $output = new self();
        foreach ($this->container as $content) {
            $result = call_user_func($closure, $content);
            $output->push($result);
        }

        return $output;
    }

    public function readonly(): ReadonlyBox
    {
        return new ReadonlyBox(($this->container));
    }

    public function clear(): void
    {
        $this->container->removeAll($this->container);
    }
}
