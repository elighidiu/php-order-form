<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

//we are going to use session variables so we need to enable sessions
session_start();

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();


// define variables and set to empty values
$email = $street = $streetnumber = $city = $zipcode = ""; 
$emailErr = $streetErr = $streetnumberErr = $cityErr = $zipcodeErr = "";

$formValid= false;
$deliveryTime = getDeliveryTime();

//we check whether the form has been submitted using $_SERVER["REQUEST_METHOD"]. If the REQUEST_METHOD is POST, then the form has been submitted - and it should be validated. If it has not been submitted, skip the validation and display a blank form.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $formValid=false;
      } else {
        $email = test_input($_POST["email"]); //validate email
        //i use PHP's filter_var() function to check whether an email address is well-formed 
        $formValid= true;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
            $emailErr = "Invalid email format";
            $formValid=false;
          }
        $_SESSION["email"]=$_POST["email"];
        //echo  $_SESSION["email"];
      }
    
 
    //add $street, $streetnumber, $city and $zipcode as required
    if (empty($_POST["street"])) {
        $streetErr = "Street is required";
        $formValid=false;
    } else {
        $street= $_POST["street"];
        $formValid=true;
        $_SESSION["street"]=$street;
        //echo $_SESSION["street"];
    }

    if (empty($_POST["streetnumber"])) {
        $streetnumberErr = "Street number is required";
        $formValid=false;
    } else {
        $streetnumber = $_POST["streetnumber"];
        //is_numeric & preg_match can both be used to verify if number. is numeric could be decimal number or a number in scientific notation while the preg_match() checks that a value contains the digits zero to nine 
        
        if (!preg_match("/^[1-9][0-9]*$/", $streetnumber)) { 
            $streetnumberErr = "Only numbers allowed";
            $formValid=false;
        }
        $formValid=true;
        $_SESSION["streetnumber"]=$streetnumber;
        
    }

    if (empty($_POST["city"])) {
        $cityErr = "City is required";
        $formValid=false;
    } else {
        $city = $_POST["city"];
        $formValid=true;
        $_SESSION["city"]=$city;
    }

    if (empty($_POST["zipcode"])) {
        $zipcodeErr = "zipcode is required";
        $formValid=false;
    } else {
        $zipcode = $_POST["zipcode"];
        if (!preg_match("/^[1-9][0-9]*$/", $zipcode)) {
            $zipcodeErr = "Only numbers allowed";
            $formValid=false;
        }
        $formValid=true;
        $_SESSION["zipcode"]=$zipcode;
    }

} 

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


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

//displaying food & drinks with food by default
if(!isset($_GET["food"]) ||  $_GET["food"]== 1) {  
//your products with their price.
    $products = [
        ['name' => 'Club Ham', 'price' => 3.20],
        ['name' => 'Club Cheese', 'price' => 3],
        ['name' => 'Club Cheese & Ham', 'price' => 4],
        ['name' => 'Club Chicken', 'price' => 4],
        ['name' => 'Club Salmon', 'price' => 5]
    ];
} else {

    $products = [
        ['name' => 'Cola', 'price' => 2],
        ['name' => 'Fanta', 'price' => 2],
        ['name' => 'Sprite', 'price' => 2],
        ['name' => 'Ice-tea', 'price' => 3],
    ];
}

//calculate totalValue
$totalValue = 0;

if(isset($_POST['products'])){
    $_SESSION=$_POST['products'];
    foreach (($_POST['products']) as $i => $product) {
        $totalValue += ($products[$i]['price']);
       
    }
}

//set cookie for totalValue
if (isset($_POST["totalValue"])){
    setcookie("totalValue", $totalValue, 0, "/");
}

function getDeliveryTime (){
    $currentTime = date("h:i"); //get the current Hour and minutes
    if(isset($_POST["express_delivery"])) {  //verify if the checkbox for express delivery is checked
        $expressDelivery= date("H:i" ,strtotime('+45 minutes',strtotime($currentTime))); //Using the date function to set the format of the date to be returned then using strtotime to add the increase or decrease of time then after a comma use another strtotime passing in the start date and time.
        return "Your order will be delivered at " . $expressDelivery . "</br>";
    } else {
        $normalDelivery= date("H:i" ,strtotime('+2 hours',strtotime($currentTime)));
        return "Your order will be delivered at " . $normalDelivery . "</br>";
    }
}


require 'form-view.php';