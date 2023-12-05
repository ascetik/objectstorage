<?php

namespace Ascetik\ObjectStorage\Container;

use SplObjectStorage;

class Box implements \Countable,  \IteratorAggregate
{
    private SplObjectStorage $container;

    public function __construct()
    {
        $this->container = new SplObjectStorage();
    }

    public function isEmpty():bool
    {
        return $this->container->count() == 0;
    }

    public function contains(object $instance)
    {
        foreach($this->container as $content)
        {
            if($instance === $content){
                return true;
            }
        }
        return false;
    }

    public function hasAny(object $instance)
    {
        foreach($this->container as $content)
        {
            if($instance == $content){
                return true;
            }
        }
        return false;
    }

    public function set(object $instance, mixed $offset = null): void
    {
        $this->container->attach($instance, $offset);
    }

    public function clear(): void
    {
        $this->container->removeAll($this->container);
    }
    
    public function count(): int
    {
        return $this->container->count();
    }

    public function getIterator(): SplObjectStorage
    {
        return $this->container;
    }
}
