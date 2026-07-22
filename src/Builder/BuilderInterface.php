<?php

namespace DesignPatterns\Origami\Builder;

use DesignPatterns\Origami\ComponentInterface;
use InvalidArgumentException;

interface BuilderInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function addSection(string $title, int $parentId): int;

    /**
     * @throws InvalidArgumentException
     */
    public function addItem(string $title, int $parentId): int;

    public function getProduct(): ComponentInterface;
}
