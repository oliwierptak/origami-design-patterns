<?php

namespace DesignPatterns\Origami\Visitor;

use DesignPatterns\Origami\Item\ItemInterface;
use DesignPatterns\Origami\Section\SectionInterface;
use DesignPatterns\Origami\Visitor\VisitorInterface;

class TextVisitor implements VisitorInterface
{
    private string $result = '';

    private string $indent = '';

    public function getResult(): string
    {
        return trim($this->result);
    }

    public function visitItem(ItemInterface $item): void
    {
        $this->result .= $item->getTitle() . " ";
    }

    public function visitSection(SectionInterface $section): void
    {
        $currentIndent = $this->indent;
        $this->result .= "\n " . $this->indent . "> " . $section->getItem()->getTitle() . " | ";

        foreach ($section->getComponents() as $component) {
            $this->indent = $currentIndent . '  ';

            $component->accept($this);
        }

        $this->indent = $currentIndent;

    }
}