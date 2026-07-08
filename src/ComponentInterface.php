<?php

namespace DesignPatterns\Origami;

use DesignPatterns\Origami\Visitor\VisitorInterface;

interface ComponentInterface extends IteratorInterface
{
    public function accept(VisitorInterface $visitor): void;
}
