<?php
//phpmotors controller

//create or access a SESSION
if (!isset($_SESSION)){
  session_start();
}


// Get the database connection file
require_once 'library/connections.php';
// Get the PHP Motors model for use as needed
require_once 'model/main-model.php';
//Get the functions to use as needed
require_once 'library/functions.php';

//dynamic page title
$pageTitle = 'Home';

// Build a navigation bar from the functions file
$navList = navigation();


$action = filter_input(INPUT_POST, 'action');
 if ($action == NULL){
  $action = filter_input(INPUT_GET, 'action');
 }

//control statement to check for the cookie
//check if the firstname cookie exists, get it's value
if(isset($_COOKIE['firstname'])){
  $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_STRING);
}
//HERE IS ME TRYING TO REDO THE COOKIE WITH A SESSION?
//if ($_SESSION['loggedin']){
//  $clientFirstname = $_SESSION['clientData']['clientFirstname'];
//}

 switch ($action){
   //I can test this template case by typing localhost/phpmotors/?action=template into the browser
    case 'template':
      include 'view/template.php';
     break;
    
    default:
     include 'view/home.php';
     break;
   }
