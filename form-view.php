
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
    <title>Order food & drinks</title>
</head>
<body>
<div class="container">
    <h1>Order food in restaurant "the Personal Ham Processors"</h1>
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

<?php

?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> <!--the $_SERVER["PHP_SELF"] sends the submitted form data to the page itself, instead of jumping to a different page. This way, the user will get error messages on the same page as the form. $_SERVER["PHP_SELF"] exploits can be avoided by using the htmlspecialchars() function-->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">E-mail:</label>
                <input type="text" id="email" name="email" class="form-control" value="<?php if(isset($_POST['email'])) {echo $_POST['email'];} ?>"/><span class="error">* <?php echo $emailErr;?></span> <!--display error field required-->
            </div>
            <div></div>
        </div>

        <fieldset>
            <legend>Address</legend>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="street">Street:</label>
                    <input type="text" name="street" id="street" class="form-control"  value="<?php echo $street; ?>"/><span class="error">* <?php echo $streetErr;?></span> <!--display error field required-->
                </div>
                <div class="form-group col-md-6">
                    <label for="streetnumber">Street number:</label>
                    <input type="text" id="streetnumber" name="streetnumber" class="form-control"  value="<?php echo $streetnumber; ?>">
                    <span class="error">* <?php echo $streetnumberErr;?></span> <!--display error field required-->
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" class="form-control"  value="<?php echo $city; ?>">
                    <span class="error">* <?php echo $cityErr;?></span> <!--display error field required-->
                </div>
                <div class="form-group col-md-6">
                    <label for="zipcode">Zipcode</label>
                    <input type="text" id="zipcode" name="zipcode" class="form-control"  value="<?php echo $zipcode; ?>">
                    <span class="error">* <?php echo $zipcodeErr;?></span> <!--display error field required-->
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Products</legend>
            <?php foreach ($products AS $i => $product): ?>
                <label>
                    <input type="checkbox" value="1" name="products[<?php echo $i ?>]"/> <?php echo $product['name'] ?> -
                    &euro; <?php echo number_format($product['price'], 2) ?></label><br />
            <?php endforeach; ?>
        </fieldset>
        
        <label>
            <input type="checkbox" name="express_delivery" value="5" /> 
            Express delivery (+ 5 EUR) 
        </label>
            
        <button type="submit" class="btn btn-primary" name="submit">Order!</button>
    </form>

    <footer><p>You already ordered <strong>&euro; <?php echo $totalValue ?></strong> in food and drinks.</p>
    <p><?php if (((!empty($_POST["email"])) && $formValid) && ((!empty($_POST["street"])) && $formValid) && ((!empty($_POST["streetnumber"])) && $formValid) && ((!empty($_POST["city"])) && $formValid) && ((!empty($_POST["zipcode"])) && $formValid)) { echo "Your order has been sent. " .$deliveryTime; } ?>
    </p>
    </footer>
</div>

<style>
    footer {
        text-align: center;
    }
</style>
</body>
</html>
