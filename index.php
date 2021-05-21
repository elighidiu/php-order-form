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

//we check whether the form has been submitted using $_SERVER["REQUEST_METHOD"]. If the REQUEST_METHOD is POST, then the form has been submitted - and it should be validated. If it has not been submitted, skip the validation and display a blank form.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
      } else {
        $email = test_input($_POST["email"]); //validate email
        //i use PHP's filter_var() function to check whether an email address is well-formed 
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
            $emailErr = "Invalid email format";
          }
      }
    
 
    //add $street, $streetnumber, $city and $zipcode as required
    if (empty($_POST["street"])) {
        $streetErr = "Street is required";
    } else {
        $street = $_POST["street"];
    }

    if (empty($_POST["streetnumber"])) {
        $streetnumberErr = "Street number is required";
    } else {
        $streetnumber = $_POST["streetnumber"];
        ///^[1-9][0-9]*$/ This forces the first digit to only be between 1 and 9, so you can't have leading zeros. It also forces it to be at least one digit long.
        if (!preg_match("/^[1-9][0-9]*$/", $streetnumber)) { 
            $streetnumberErr = "Only numbers allowed";
        }
    }

    if (empty($_POST["city"])) {
        $cityErr = "City is required";
    } else {
        $city = $_POST["city"];
    }

    if (empty($_POST["zipcode"])) {
        $zipcodeErr = "zipcode is required";
    } else {
        $zipcode = $_POST["zipcode"];
        if (!preg_match("/^[1-9][0-9]*$/", $zipcode)) {
            $zipcodeErr = "Only numbers allowed";
        }
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