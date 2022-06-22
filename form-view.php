<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
            content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
            rel="stylesheet"/>
        <title>Shrimptech enterprise</title>
    </head>
    <body>
        <div class="container my-4">
            <h1>Place your order</h1>
            
            <nav class="mb-4">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="?page=1">Order sports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=2">Order movies</a>
                    </li>
                </ul>
            </nav>

            <form method="post" action="<?= $_SERVER['REQUEST_URI']; ?>">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email">E-mail:</label>
                        <input type="email" id="email" name="email" class="form-control" 
                        <?php 
                            if(!empty($_SESSION['email'])){
                                $emailValue = $_SESSION['email'];
                                echo "value='$emailValue'"; 
                            }; 
                        ?> required>
                        <?php 
                            if ($_POST["empty_email"]){
                                echo '<div class="alert alert-danger mt-2" role="alert">Please enter your e-mail</div>';
                            };
                            if ($_POST["not_an_email"] && !$_POST["empty_email"]){
                                echo '<div class="alert alert-danger mt-2" role="alert">This is not a valid e-mailadress</div>';
                            }
                        ?>
                    </div>
                    <div></div>
                </div>

                <fieldset>
                    <legend>Address</legend>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="street">Street:</label>
                            <input type="text" name="street" id="street" class="form-control"
                            <?php 
                                if(!empty($_SESSION['street'])){
                                    $streetValue = $_SESSION['street'];
                                    echo "value='$streetValue'"; 
                                }; 
                            ?> required>
                            <?php 
                                if ($_POST["empty_street"]){
                                    echo '<div class="alert alert-danger mt-2" role="alert">Please enter your street</div>';
                                };
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="streetnumber">Street number:</label>
                            <input type="text" id="streetnumber" name="streetnumber" class="form-control"
                            <?php 
                                if(!empty($_SESSION['streetnumber'])){
                                    $streetnumberValue = $_SESSION['streetnumber'];
                                    echo "value='$streetnumberValue'"; 
                                };
                            ?> required>
                            <?php 
                                if ($_POST["empty_streetnumber"]){
                                    echo '<div class="alert alert-danger mt-2" role="alert">Please enter your street number</div>';
                                };
                            ?>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="city">City:</label>
                            <input type="text" id="city" name="city" class="form-control"
                            <?php 
                                if(!empty($_SESSION['city'])){
                                    $cityValue = $_SESSION['city'];
                                    echo "value='$cityValue'"; 
                                }; 
                            ?> required>
                            <?php 
                                if ($_POST["empty_city"]){
                                    echo '<div class="alert alert-danger mt-2" role="alert">Please enter your city</div>';
                                };
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="zipcode">Zipcode</label>
                            <input type="text" id="zipcode" name="zipcode" class="form-control"
                            <?php 
                                if(!empty($_SESSION['zipcode'])){
                                    $zipcodeValue = $_SESSION['zipcode'];
                                    echo "value='$zipcodeValue'"; 
                                }; 
                            ?> required>
                            <?php 
                                if ($_POST["empty_zipcode"]){
                                    echo '<div class="alert alert-danger mt-2" role="alert">Please enter your zipcode</div>';
                                };
                                if ($_POST["zipcode_not_numberic"] && !$_POST["empty_zipcode"]){
                                    echo '<div class="alert alert-danger mt-2" role="alert">Your zipcode can only contain numbers</div>';
                                };
                            ?>
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <div class="form-row">
                        <?php foreach ($products as $i => $product): ?>
                            <div class="form-group col-md-12">
                                <select name="product-<?= $i?>" id="product-<?= $i?>" class="mr-2" required>
                                    <?php
                                    for($j = 0; $j < 6; $j++){
                                        if ($j === 0) {
                                            echo "<option selected value='$j'>$j</option>";
                                        } else {
                                            echo "<option value='$j'>$j</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <label for="product-<?= $i?>"><?= $product['name'] ?> -
                                    &euro; <?= number_format($product['price'], 2) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    
                                <?php 
                                    if ($_POST["empty_product"]){
                                        echo '<div class="alert alert-danger mt-2" role="alert">Please select one of more products</div>';
                                    };
                                ?>
                    </div>
                </fieldset>
                
                <fieldset class="mb-4">
                    <div class="form-check">
                        <input type="checkbox" id="fast-delivery" name="fast-delivery" class="form-check-input">
                        <label for="fast-delivery" class="form-check-label">Express delivery? (€5 for delivery in 45min instead of 24h)</label>
                    </div>
                </fieldset>

                <button type="submit" class="btn btn-primary" name="place-order">Order!</button>
            </form>

            <?php 
                if($formSubmitted){
                    echo "<p class='mt-2'>You've ordered $orderedProducts for &euro;$currentOrderCost.</p>";
                    echo "<p class='mt-2'>Your order will be sent to $orderAdress</p>";
                    echo "<p class='mt-2'>It will be delivered in $deliveryTime, so you can expect it at $deliveryTimestamp</p>";
                    echo "<p class='mt-2'>Your most popular product seems to be $mostPopularProductName, you have already ordered it $mostPopularProductAmount times.</p>";
                }
            ?>

            <footer>You already paid <strong>&euro;<?= $totalValue ?></strong> in total.</footer>
        </div>

        <style>
            footer {
                text-align: center;
            }
        </style>
        <script src="script.js"></script>
    </body>
</html>