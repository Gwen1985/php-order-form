<?php

declare(strict_types=1);

class Food
{
    protected static $foodProducts;
    protected string $name;
    protected float $price;

    /**
     * Products constructor.
     * @param string $name
     * @param float $price
     */
    public function __construct(string $name, float $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public static function getFoodProducts()
    {
        return self::$foodProducts;
    }



}