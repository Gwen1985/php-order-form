<?php

declare(strict_types=1);


class Drinks extends Food
{

    /**
     * Drinks constructor.
     */
    public function __construct(string $name, float $price)
    {
        parent::__construct($name, $price);
    }

}