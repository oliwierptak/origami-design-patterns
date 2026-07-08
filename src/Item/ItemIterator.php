<?php

namespace DesignPatterns\Origami\Item;

use DesignPatterns\Origami\Action\ActionInterface;
use DesignPatterns\Origami\IteratorInterface;

class ItemIterator implements IteratorInterface
{
    public function __construct(private ItemInterface $item)
    {
    }

    public function iterate(?ActionInterface $sectionAction = null, ?ActionInterface $itemAction = null): void
    {
        $itemAction?->apply($this->item);
    }
}