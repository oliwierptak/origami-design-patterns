<?php

namespace DesignPatterns\Origami\Action;

use DesignPatterns\Origami\Item\ItemInterface;

class ConvertSpaceToUnderscore implements ActionInterface
{
    public function apply(ItemInterface $item): void
    {
        $item->setTitle($this->replace($item->getTitle()));
    }

    private function replace(string $value): string
    {
        return str_replace(' ', '_', $value);
    }
}