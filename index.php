<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

//we are going to use session variables so we need to enable sessions
session_start();



// define variables and set to empty values
$email = $street = $streetnumber = $city = $zipcode = ""; 
$emailErr = $streetErr = $streetnumberErr = $cityErr = $zipcodeErr = "";

$formValid= false;

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
      }
    
 
    //add $street, $streetnumber, $city and $zipcode as required
    if (empty($_POST["street"])) {
        $streetErr = "Street is required";
        $formValid=false;
    } else {
        $street= $_POST["street"];
        $formValid=true;
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
    }

    if (empty($_POST["city"])) {
        $cityErr = "City is required";
        $formValid=false;
    } else {
        $city = $_POST["city"];
        $formValid=true;
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

//your products with their price.
$products = [
    ['name' => 'Club Ham', 'price' => 3.20],
    ['name' => 'Club Cheese', 'price' => 3],
    ['name' => 'Club Cheese & Ham', 'price' => 4],
    ['name' => 'Club Chicken', 'price' => 4],
    ['name' => 'Club Salmon', 'price' => 5]
];

$products = [
    ['name' => 'Cola', 'price' => 2],
    ['name' => 'Fanta', 'price' => 2],
    ['name' => 'Sprite', 'price' => 2],
    ['name' => 'Ice-tea', 'price' => 3],
];

$totalValue = 0;

require 'form-view.php';