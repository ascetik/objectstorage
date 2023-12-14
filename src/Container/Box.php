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

use Ascetik\ObjectStorage\DTO\ItemComparator;
use Ascetik\ObjectStorage\Enums\BoxSortOrder;
use Ascetik\ObjectStorage\Traits\ReadableBox;
use Closure;
use SplObjectStorage;

/**
 * @version 1.0.0
 */
class Box implements \Countable,  \IteratorAggregate
{
    use ReadableBox;

    public const IGNORE_ON_MISSING = 0;
    public const APPEND_ON_MISSING = 1;
    public const PREPEND_ON_MISSING = 2;

    public function __construct(
        private SplObjectStorage $container = new SplObjectStorage()
    ) {
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

    public function sort(callable $sorting, BoxSortOrder $order = BoxSortOrder::ASC): void
    {

        if ($this->container->count() == 0) {
            return;
        }

        $pivot = $this->last();
        $tail = new self();
        $head = new self();

        $comparator = new ItemComparator($sorting, $order);

        foreach ($this->container as $content) {
            if ($content !== $pivot) {
                $result = $comparator->compare($pivot, $content);
                $store = $result->reversed() ? $head : $tail;
                $store->push($content, $this->container->offsetGet($content));
            }
        }

        $tail->sort($sorting, $order);
        $head->sort($sorting, $order);
        $tail->push($pivot, $this->container->offsetGet($pivot));
        $tail->union($head);

        $this->clear();
        $this->union($tail);
    }

    public function sortReverse(callable $sorting)
    {
        $this->sort($sorting, BoxSortOrder::DESC);
    }

    public function atKey(int $key)
    {
        if ($key < $this->container->count() - 1) {
            $this->container->rewind();
            foreach ($this->container as $content) {
                if ($this->container->key() == $key) {
                    return $this->container->current();
                }
            }
        }
        return null;
    }

    public function associate(object $reference, mixed $offset, int $append = self::IGNORE_ON_MISSING)
    {
        if ($this->container->contains($reference)) {
            $this->container->offsetSet($reference, $offset);
            return;
        }
        match ($append) {
            self::APPEND_ON_MISSING => $this->push($reference, $offset),
            self::PREPEND_ON_MISSING => $this->unshift($reference, $offset),
            default => null
        };
    }

    public function union(self $box)
    {
        $this->container->addAll($box->container);
    }

    public function clear(): void
    {
        $this->container->removeAll($this->container);
    }

    public function readonly(): ReadonlyBox
    {
        return new ReadonlyBox($this->container);
    }
}
