<?php

namespace DesignPatterns\Origami\Section;

use DesignPatterns\Origami\Action\DefaultAction;
use DesignPatterns\Origami\Action\ActionInterface;
use DesignPatterns\Origami\IteratorInterface;

class SectionIterator implements IteratorInterface
{
    public function __construct(private SectionInterface $section)
    {
    }

    public function iterate(?ActionInterface $sectionAction = null, ?ActionInterface $itemAction = null): void
    {
        $sectionAction = $sectionAction === null ? new DefaultAction() : $sectionAction;
        $itemAction = $itemAction === null ? new DefaultAction() : $itemAction;

        $this->iterateOverSection($sectionAction);

        foreach ($this->section->getComponents() as $component) {
            $component->iterate($sectionAction, $itemAction);
        }
    }

    private function iterateOverSection(ActionInterface $sectionAction): void
    {
        $this->section->getItem()->iterate($sectionAction, $sectionAction); //interesting...
    }
}