<?php

namespace DesignPatterns\Origami\Visitor;

use DesignPatterns\Origami\Item\ItemInterface;
use DesignPatterns\Origami\Section\SectionInterface;

interface VisitorInterface
{
    public function visitItem(ItemInterface $item): void;

    public function visitSection(SectionInterface $section): void;
}
