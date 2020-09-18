<?php

//this line makes PHP behave in a more strict way
declare(strict_types=1);

require 'form-view.php';
//Include the FOOD & DRINKS Classes
include 'Food.php';
include 'Drinks.php';

//we are going to use session variables so we need to enable sessions
session_start();

//function whatIsHappening()
//{
//echo '<h2>$_GET</h2>';
//var_dump($_GET);
//echo '<h2>$_POST</h2>';
//var_dump($_POST);
//echo '<h2>$_COOKIE</h2>';
//var_dump($_COOKIE);
//echo '<h2>$_SESSION</h2>';
//var_dump($_SESSION);
//}
//
//whatIsHappening();

//  FOOD PRODUCTS
$foodProducts = [
    new Food('Club Ham', 3.2),
    new Food('Club Cheese', 3),
    new Food('Club Cheese & Ham', 4),
    new Food('Club Chicken', 4),
    new Food('Club Salmon', 5),
];

//  DRINKS PRODUCTS
$drinkProducts = [
    new Drinks('Kinohbi 9th edition ', 25),
    new Drinks('Black Tot Rum 40 Years', 230),
    new Drinks('Sprite', 2),
    new Drinks('Ice Tea', 3),
];

var_dump($foodProducts);

//SWITCH BETWEEN FOOD AND DRINKS
$foodSelected = $foodProducts;
if ($foodSelected) {
    $products = $foodProducts;
} else {
    $products = $drinkProducts;
}

//$totalValue = 0;