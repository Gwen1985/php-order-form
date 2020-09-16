<?php

//this line makes PHP behave in a more strict way
declare(strict_types=1);

require 'product.php';

//we are going to use session variables so we need to enable sessions
session_start();

//function whatIsHappening()
//{
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
//    echo '<h2>$_POST</h2>';
//    var_dump($_POST);
//    echo '<h2>$_COOKIE</h2>';
//    var_dump($_COOKIE);
//    echo '<h2>$_SESSION</h2>';
//    var_dump($_SESSION);
//}
//
//whatIsHappening();

//  FOOD PRODUCTS
//$products = [
//    ['name' => 'Club Ham', 'price' => 3.20],
//    ['name' => 'Club Cheese', 'price' => 3],
//    ['name' => 'Club Cheese & Ham', 'price' => 4],
//    ['name' => 'Club Chicken', 'price' => 4],
//    ['name' => 'Club Salmon', 'price' => 5]
//];

//  FOOD PRODUCTS
$foodProducts = [
    new foodProducts('Club Ham', 3.2),
    new foodProducts('Club Cheese', 3),
    new foodProducts('Club Cheese & Ham', 4),
    new foodProducts('Club Chicken', 4),
    new foodProducts('Club Salmon', 5),
];

//echo ('<pre>');
//var_dump($foodProducts);
//var_dump($foodProducts[1]->name);
//echo ('</pre>');


//  DRINKS PRODUCTS
//$productsDrinks = [
//    ['name' => 'Cola', 'price' => 2],
//    ['name' => 'Fanta', 'price' => 2],
//    ['name' => 'Sprite', 'price' => 2],
//    ['name' => 'Ice-tea', 'price' => 3],
//];

//  DRINKS PRODUCTS
$drinkProducts = [
    new drinkProducts('Cola', 2),
    new drinkProducts('Fanta', 2),
    new drinkProducts('Sprite', 2),
    new drinkProducts('Ice Tea', 3),
];
//echo ('<pre>');
//var_dump($drinkProducts);
//var_dump($drinkProducts[1]->name);
//echo ('</pre>');
//die;

// SWITCH BETWEEN FOOD AND DRINKS
$foodSelected = $_GET['food'];
if ($foodSelected) {
    foodProducts:: $foodProducts;
} else {
    $products = $drinkProducts;
}

$totalValue = 0;

require 'form-view.php';


