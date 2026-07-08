<?php

namespace DesignPatterns\Origami\Item;

use DesignPatterns\Origami\ComponentInterface;

interface ItemInterface extends ComponentInterface
{
    public function setTitle(string $value): void;

    public function getTitle(): string;
}