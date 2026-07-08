<?php

namespace DesignPatterns\Origami\Section;

use DesignPatterns\Origami\ComponentInterface;
use DesignPatterns\Origami\Item\ItemInterface;

interface SectionInterface extends ComponentInterface
{
    public function getItem(): ItemInterface;

    public function addComponent(ComponentInterface $component): void;

    /**
     * @return ComponentInterface[]
     */
    public function getComponents(): array;
}