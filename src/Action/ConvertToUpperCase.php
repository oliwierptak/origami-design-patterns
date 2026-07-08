<?php

namespace DesignPatterns\Origami\Action;

use DesignPatterns\Origami\Item\ItemInterface;

class ConvertToUpperCase implements ActionInterface
{
    public function apply(ItemInterface $item): void
    {
        $item->setTitle($this->convert($item->getTitle()));
    }

    private function convert(string $value): string
    {
        return mb_strtoupper($value, 'UTF-8');
    }
}