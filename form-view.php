<?php // This file is mostly containing things for your view / html ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
    <title>Shrimp store</title>
</head>
<body>
<div class="container">
    <h1>Place your order</h1>
    <?php // Navigation for when you need it ?>
    <?php /*
    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="?food=1">Order food</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?food=0">Order drinks</a>
            </li>
        </ul>
    </nav>
    */ ?>
    <form method="post" action="index.php">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" class="form-control"/>
                <?php 
                    if ($_SESSION["empty_email"]){
                        echo '<div class="alert alert-danger mt-2" role="alert">Please enter your e-mail</div>';
                    };
                ?>
            </div>
            <div></div>
        </div>

        <fieldset>
            <legend>Address</legend>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="street">Street:</label>
                    <input type="text" name="street" id="street" class="form-control">
                    <?php 
                        if ($_SESSION["empty_street"]){
                            echo '<div class="alert alert-danger mt-2" role="alert">Please enter your street</div>';
                        };
                    ?>
                </div>
                <div class="form-group col-md-6">
                    <label for="streetnumber">Street number:</label>
                    <input type="text" id="streetnumber" name="streetnumber" class="form-control">
                    <?php 
                        if ($_SESSION["empty_streetnumber"]){
                            echo '<div class="alert alert-danger mt-2" role="alert">Please enter your street number</div>';
                        };
                    ?>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" class="form-control">
                    <?php 
                        if ($_SESSION["empty_city"]){
                            echo '<div class="alert alert-danger mt-2" role="alert">Please enter your city</div>';
                        };
                    ?>
                </div>
                <div class="form-group col-md-6">
                    <label for="zipcode">Zipcode</label>
                    <input type="text" id="zipcode" name="zipcode" class="form-control">
                    <?php 
                        if ($_SESSION["empty_zipcode"]){
                            echo '<div class="alert alert-danger mt-2" role="alert">Please enter your zipcode</div>';
                        };
                    ?>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Products</legend>
            <?php foreach ($products as $i => $product): ?>
                <label>
                    <input type="checkbox" value="<?= $i ?>" name="product[]"/> <?= $product['name'] ?> -
                    &euro; <?= number_format($product['price'], 2) ?></label><br />
            <?php endforeach; ?>
        </fieldset>

        <button type="submit" class="btn btn-primary" name="place-order">Order!</button>
    </form>

    <?php if($formSubmitted){
        echo "<p>You've ordered $orderedProducts for &euro;$currentOrderCost.</p>";
        echo "<p>Your order will be sent to $orderAdress</p>";
    }
    ?>

    <footer>You already ordered <strong>&euro; <?= $_SESSION["totalValue"] ?></strong> in sport items.</footer>
</div>

<style>
    footer {
        text-align: center;
    }
</style>
<script src="script.js"></script>
</body>
</html>