<?php

namespace DesignPatterns\Origami;

use DesignPatterns\Origami\Action\ActionInterface;

interface IteratorInterface
{
    public function iterate(?ActionInterface $sectionAction = null, ?ActionInterface $itemAction = null): void;
}
