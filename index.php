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
        ['name' => 'The Color of Pomegranades', 'price' => 18],
        ['name' => 'Dogtooth', 'price' => 20],
        ['name' => 'The Killing of a Sacred Deer', 'price' => 9],
        ['name' => 'Wrong Cops', 'price' => 25],
        ['name' => 'D\'Ardennen', 'price' => 50],
        ['name' => 'Rundskop', 'price' => 90]
    ];
}



$formSubmitted = false;
$fields = ["email", "street", "streetnumber", "city", "zipcode", "product"];
$valid = true;

if(!empty($_SESSION["totalValue"])){
    $totalValue = $_SESSION["totalValue"];
} else {
    $totalValue = 0;
};

foreach ($fields as $field){
        $_SESSION["empty_" . $field] = false;
        unset($field);
};

$_SESSION["zipcode_not_numberic"] = false;
$_SESSION["not_an_email"] = false;

function validate(){

    global $valid;

    $textFields = ["email", "street", "streetnumber", "city", "zipcode"];

    foreach ($textFields as $field){
        if (empty($_POST[$field])){
            $_SESSION["empty_" . $field] = true;
            $valid = false;
        };
    };

    if(empty($_POST['product'])){
        $_SESSION["empty_product"] = true;
        $valid = false;
    };

    if (!is_numeric($_POST['zipcode'])){
        $_SESSION["zipcode_not_numberic"] = true;
        $valid = false;
    };

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $_SESSION["not_an_email"] = true;
        $valid = false;
    };
};


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


if (isset($_POST["place-order"])){

    validate();

    global $valid;

    if ($valid) {

        $formSubmitted = true;
        $orderedProductsArr = [];
        $orderedProducts = "";
        $currentOrderCost = 0;
        if(!empty($_POST['product'])){
            foreach ($_POST["product"] as $product){
                array_push($orderedProductsArr, $products[$product]["name"]);
                $totalValue += $products[$product]["price"];
                $_SESSION["totalValue"] = $totalValue;
                $currentOrderCost += $products[$product]["price"];
            }
        };
        if (count($orderedProductsArr) > 1){
            $orderedProducts = implode(", ", $orderedProductsArr);
            $orderedProducts = substr_replace($orderedProducts, ' and', strrpos($orderedProducts, ','), 1);
        } else if (count($orderedProductsArr) === 1){
            $orderedProducts = $orderedProductsArr[0];
        };

        $orderAdress = $_POST["street"] . " " . $_POST["streetnumber"] . ", " . $_POST["zipcode"] . " " . $_POST["city"];
    }
    
    
}

require 'form-view.php';

// if (@$_GET["page"] == 1 || !isset($_GET["page"])){
//     require 'form-view.php';
// } else {
//     require "second-page.php";
// }