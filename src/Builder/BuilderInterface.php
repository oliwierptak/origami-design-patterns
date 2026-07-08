<?php

namespace DesignPatterns\Origami\Builder;

use DesignPatterns\Origami\ComponentInterface;

interface BuilderInterface
{
    public function addSection(string $title, int $parentId): int;

    public function addItem(string $title, int $parentId): int;

    public function getProduct(): ComponentInterface;
}
