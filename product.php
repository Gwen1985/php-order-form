<?php

class foodProducts
{
    public $name = '';
    public $price = 0;

    public function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    function get_name()
    {
        return ucwords($this->name);
    }

    function get_price()
    {
        return $this->price;
    }
};

class drinkProducts
{
    public $name = '';
    public $price = 0;

    public function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    function get_name()
    {
        return ucwords($this->name);
    }

    function get_price()
    {
        return $this->price;
    }
};