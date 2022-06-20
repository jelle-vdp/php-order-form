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
}


echo isset($_POST["place-order"]);

// TODO: provide some products (you may overwrite the example)
$products = [
    ['name' => 'Short shorts', 'price' => 18],
    ['name' => 'Cigarettes', 'price' => 7],
    ['name' => 'Wiener dog', 'price' => 260],
    ['name' => 'Getting high in the morning', 'price' => 30],
    ['name' => 'Buying things off the internet', 'price' => 300],
    ['name' => 'Sports', 'price' => 550]
];

$formSubmitted = false;

$fields = ["email", "street", "streetnumber", "city", "zipcode"];

$_SESSION["totalValue"] = 0;

foreach ($fields as $field){
    $_SESSION["empty_" . $field] = false;
}

function validate(){
    $valid = true;

    global $fields;

    foreach ($fields as $field2) {
        if (empty($_POST["empty_" . $field2])){
            $_SESSION["empty_" . $field2] = true;
            $valid = false;
        }
    }

    return $valid;
}

// function handleForm()
// {
//     // TODO: form related tasks (step 1)

//     // Validation (step 2)
//     $invalidFields = validate();
//     if (!empty($invalidFields)) {
//         // TODO: handle errors
//     } else {
//         // TODO: handle successful submission
//     }
// }



// // TODO: replace this if by an actual check
// 
// if ($formSubmitted) {
//     handleForm();
// }


if (isset($_POST["place-order"]) && validate()){
    $formSubmitted = true;
    $orderedProductsArr = [];
    $currentOrderCost = 0;
    if(!empty($_POST['product'])){
        foreach ($_POST["product"] as $product){
            array_push($orderedProductsArr, $products[$product]["name"]);
            $_SESSION["totalValue"] += $products[$product]["price"];
            $currentOrderCost += $products[$product]["price"];
        }
    };
    if (count($orderedProductsArr) !== 1){
        $orderedProducts = implode(", ", $orderedProductsArr);
        $orderedProducts = substr_replace($orderedProducts, ' and', strrpos($orderedProducts, ','), 1);
    } else {
        $orderedProducts = $orderedProductsArr[0];
    };

    $orderAdress = $_POST["street"] . " " . $_POST["streetnumber"] . ", " . $_POST["zipcode"] . " " . $_POST["city"];
    
}

require 'form-view.php';