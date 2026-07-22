<?php

namespace DesignPatterns\Origami\Action;

use DesignPatterns\Origami\Item\ItemInterface;

interface ActionInterface
{
    public function apply(ItemInterface $item): void;
}
