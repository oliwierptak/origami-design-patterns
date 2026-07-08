<?php

namespace DesignPatterns\Origami\Builder;

use DesignPatterns\Origami\Item\Item;
use DesignPatterns\Origami\Item\ItemInterface;
use DesignPatterns\Origami\Section\Section;
use DesignPatterns\Origami\Section\SectionInterface;
use DesignPatterns\Origami\ComponentInterface;
use InvalidArgumentException;

class ComponentBuilder implements BuilderInterface
{
    private int $currentId = 0;

    /**
     * @var ComponentInterface[]
     */
    private array $components = [];

    public function addItem(string $title, int $parentId): int
    {
        return $this->addComponent(new Item($title), $parentId);
    }

    private function addComponent(ComponentInterface $component, int $parentId): int
    {
        $this->validate($parentId);

        if ($parentId === -1) {
            $this->components[$this->currentId] = $component;

            return $this->currentId++;
        }

        /**
         * @var SectionInterface $section
         */
        $section = $this->components[$parentId];
        $section->addComponent($component);

        $this->components[$parentId] = $section;
        $this->components[$this->currentId] = $component;

        return $this->currentId++;
    }

    private function validate(int $parentId): void
    {
        if ($parentId === -1 && count($this->components) > 0) {
            throw new InvalidArgumentException('Duplicated root');
        }

        if (isset($this->components[$parentId]) && $this->components[$parentId] instanceof ItemInterface) {
            throw new InvalidArgumentException('Cannot add Item to another Item');
        }

        if ($parentId > 0 && !isset($this->components[$parentId])) {
            throw new InvalidArgumentException('Invalid parentId');
        }
    }

    public function addSection(string $title, int $parentId): int
    {
        return $this->addComponent(new Section(new Item($title)), $parentId);
    }

    public function getProduct(): ComponentInterface
    {
        return array_first($this->components);
    }
}