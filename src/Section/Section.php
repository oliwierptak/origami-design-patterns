<?php

namespace DesignPatterns\Origami\Section;

use DesignPatterns\Origami\Action\ActionInterface;
use DesignPatterns\Origami\ComponentInterface;
use DesignPatterns\Origami\Item\ItemInterface;
use DesignPatterns\Origami\Visitor\VisitorInterface;

class Section implements SectionInterface
{
    /**
     * @var ComponentInterface[]
     */
    private array $components = [];

    public function __construct(private ItemInterface $item)
    {
    }

    public function getItem(): ItemInterface
    {
        return $this->item;
    }

    public function accept(VisitorInterface $visitor): void
    {
        $visitor->visitSection($this);
    }

    public function iterate(?ActionInterface $sectionAction = null, ?ActionInterface $itemAction = null): void
    {
        new SectionIterator($this)->iterate($sectionAction, $itemAction);
    }

    public function addComponent(ComponentInterface $component): void
    {
        $this->components[] = $component;
    }

    public function getComponents(): array
    {
        return $this->components;
    }
}