<?php

namespace DesignPatterns\Origami\Visitor;

use DesignPatterns\Origami\Item\ItemInterface;
use DesignPatterns\Origami\Section\SectionInterface;
use DesignPatterns\Origami\Visitor\VisitorInterface;

class FormattedListVisitor implements VisitorInterface
{
    /**
     * @var string[]
     */
    private array $lines = [];

    private string $indent = '';

    /**
     * @return string[]
     */
    public function getResult(): array
    {
        return $this->lines;
    }

    public function visitItem(ItemInterface $item): void
    {
        $this->lines[] = $this->indent . $item->getTitle();
    }

    public function visitSection(SectionInterface $section): void
    {
        $currentIndent = $this->indent;
        $this->lines[] = $this->indent . $section->getItem()->getTitle();

        foreach ($section->getComponents() as $component) {
            $this->indent = $currentIndent . '  ';

            $component->accept($this);
        }

        $this->indent = $currentIndent;
    }
}