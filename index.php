<?php

// This file is your starting point (= since it's the index)
// It will contain most of the logic, to prevent making a messy mix in the html

// This line makes PHP behave in a more strict way
declare(strict_types=1);

// We are going to use session variables so we need to enable sessions
session_start();

// Use this function when you need to need an overview of these variables
function whatIsHappening() {
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
};

// TODO: provide some products (you may overwrite the example)

if (@$_GET["page"] == 1 || !isset($_GET["page"])){
    $products = [
        ['name' => 'Short shorts', 'price' => 18],
        ['name' => 'Cigarettes', 'price' => 7],
        ['name' => 'Wiener dog', 'price' => 260],
        ['name' => 'Getting high in the morning', 'price' => 30],
        ['name' => 'Buying things off the internet', 'price' => 300],
        ['name' => 'Sports', 'price' => 550]
    ];
} else {
    $products = [
        ['name' => 'The Color of Pomegranates', 'price' => 18],
        ['name' => 'Dogtooth', 'price' => 20],
        ['name' => 'The Killing of a Sacred Deer', 'price' => 9],
        ['name' => 'Wrong Cops', 'price' => 25],
        ['name' => 'D\'Ardennen', 'price' => 50],
        ['name' => 'Rundskop', 'price' => 90]
    ];
}

$formSubmitted = false;
$fields = ["email", "street", "streetnumber", "city", "zipcode"];
$valid = true;

if(!empty($_SESSION["totalValue"])){
    $totalValue = $_SESSION["totalValue"];
} else {
    $totalValue = 0;
};

foreach ($fields as $field){
        $_POST["empty_" . $field] = false;
        unset($field);
};

$_POST["empty_product"] = false;
$_POST["zipcode_not_numberic"] = false;
$_POST["not_an_email"] = false;

function validate(){

    echo "valideren";

    global $valid;
    global $fields;

    foreach ($fields as $field){
        if (empty($_POST[$field])){
            $_POST["empty_" . $field] = true;
            $valid = false;
        };
    };

    $productArr = [];

    for($i = 0; $i < 6; $i++){
       if ($_POST["product-$i"] != 0){
            array_push($productArr, true);
       }
    }

    if (empty($productArr)){
        $_POST["empty_product"] = true;
        $valid = false;
    }

    if (!is_numeric($_POST['zipcode'])){
        $_POST["zipcode_not_numberic"] = true;
        $valid = false;
    };

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $_POST["not_an_email"] = true;
        $valid = false;
    };
};


if (isset($_POST["place-order"])){

    validate();

    global $valid;

    $fieldPersonalDetails = ["email", "street", "streetnumber", "city", "zipcode"];

    foreach($fieldPersonalDetails as $detail){
        if(($_POST[$detail])){
             $_SESSION[$detail] = $_POST[$detail];
        }
    };

    if ($valid) {

        $formSubmitted = true;
        $orderedProductsArr = [];
        $orderedProducts = "";
        $currentOrderCost = 0;

        for($i = 0; $i < 6; $i++){
            $orderedProductsArr[$i]["amount"] = $_POST["product-" . $i];
            $orderedProductsArr[$i]["item"] = $products[$i]["name"];
            $orderedProductsArr[$i]["price"] = $products[$i]["price"];
        };

        $secondOrderedProductsArr = [];

        foreach ($orderedProductsArr as $order){
            if ($order["amount"] != 0){
                array_push($secondOrderedProductsArr, $order["item"] . " (" . $order["amount"] . "x)");
                $currentOrderCost += $order["price"] * $order["amount"];
                $totalValue += $currentOrderCost;
                $_SESSION["totalValue"] = $totalValue;
            };
        };

        if (count($secondOrderedProductsArr) > 1){
            $orderedProducts = implode(", ", $secondOrderedProductsArr);
            $orderedProducts = substr_replace($orderedProducts, ' and', strrpos($orderedProducts, ','), 1);
        } else {
            $orderedProducts = $secondOrderedProductsArr[0];
        };

        $orderAdress = $_POST["street"] . " " . $_POST["streetnumber"] . ", " . $_POST["zipcode"] . " " . $_POST["city"];
    }
}

require 'form-view.php';