<?php

namespace DesignPatterns\Origami\Item;

use DesignPatterns\Origami\Action\ActionInterface;
use DesignPatterns\Origami\Visitor\VisitorInterface;

class Item implements ItemInterface
{
    public function __construct(private string $title)
    {
    }

    public function setTitle(string $value): void
    {
        $this->title = $value;
    }

    public function accept(VisitorInterface $visitor): void
    {
        $visitor->visitItem($this);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function iterate(?ActionInterface $sectionAction = null, ?ActionInterface $itemAction = null): void
    {
        new ItemIterator($this)->iterate($sectionAction, $itemAction);
    }
}