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
        static $defaultAction = new DefaultAction();

        $sectionAction = $sectionAction === null ? $defaultAction : $sectionAction;
        $itemAction = $itemAction === null ? $defaultAction : $itemAction;

        $this->iterateOverSection($sectionAction);

        foreach ($this->section->getComponents() as $component) {
            $component->iterate($sectionAction, $itemAction);
        }
    }

    private function iterateOverSection(ActionInterface $sectionAction): void
    {
        $sectionAction->apply($this->section->getItem());
    }
}