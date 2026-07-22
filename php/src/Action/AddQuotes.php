<?php

namespace DesignPatterns\Origami\Action;

use DesignPatterns\Origami\Item\ItemInterface;

class AddQuotes implements ActionInterface
{
    public function apply(ItemInterface $item): void
    {
        $item->setTitle($this->quote($item->getTitle()));
    }

    private function quote(string $value): string
    {
        return "'$value'";
    }
}