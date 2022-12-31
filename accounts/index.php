<?php

/*
Accounts Controller
*/

//create or access a SESSION
if (!isset($_SESSION)){
   session_start();
}

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
//get the accounts model for use as needed
require_once '../model/accounts-model.php';
//get the functions Library
require_once '../library/functions.php';
//get access to the reviews model for the review section
require_once '../model/review-model.php';


//dynamic page title
$pageTitle = 'Accounts';

// Build a navigation bar from the functions file
$navList = navigation();


//link to the registration page
$registrationPage = "<a href='/phpmotors/accounts/index.php?action=registerView' title='Login or Register for your Account'>";
$registrationPage .= "Not a member? Register Here.";
$registrationPage .= "</a>";

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
   $action = filter_input(INPUT_GET, 'action');
}


switch ($action) {
   case 'loginView':
      //dynamic page title
      $pageTitle = 'Login';
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/login.php';
      break;
   case 'registerView':
      //dynamic page title
      $pageTitle = 'Register';
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/registration.php';
      break;
   case 'Logout';
      session_unset();
      session_destroy();
      header('Location: /phpmotors/index.php');
      break;
   case 'register':
      // Filter and store the data
      $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
      $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
      $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
      $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
      $clientEmail = checkEmail($clientEmail);
      $checkPassword = checkPassword($clientPassword);

      //check for the existing email
      $existingEmail = checkEmailExists($clientEmail);

      if ($existingEmail) {
         $message = '<p class="notice">That email address already exists. Do you want to login instead?</p>';
         $_SESSION['message'] = $message;
         include '../view/login.php';
         exit;
      }

      // Check for missing data
      if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)) {
         $message = '<p>Please provide information for all empty form fields.</p>';
         $_SESSION['message'] = $message;
         include '../view/registration.php';
         exit;
      }

      // Hash the checked password
      $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

      // Send the data to the model
      $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);


      // Check and report the result
      if ($regOutcome === 1) {
         setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
         $message = "<p>Thanks for registering $clientFirstname. Please use your email and password to login.</p>";
         $_SESSION['message'] = $message;
         header('Location: /phpmotors/accounts/index.php?action=loginView');
         exit;
      } else {
         $message = "<p>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
         include '../view/registration.php';
         exit;
      }

      break;
   case 'Login';
      //Filter and store the data
      $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
      $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
      $clientEmail = checkEmail($clientEmail);
      $checkPassword = checkPassword($clientPassword);

      // Check for missing data
      if (empty($clientEmail) || empty($checkPassword)) {
         $message = '<p>Please provide information for all empty form fields.</p>';
         $_SESSION['message'] = $message;
         include '../view/login.php';
         exit;
      }

      // A valid password exists, proceed with the login process
      // Query the client data based on the email address
      $clientData = getClient($clientEmail);
      // Compare the password just submitted against
      // the hashed password for the matching client
      $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
      // If the hashes don't match create an error
      // and return to the login view
      if (!$hashCheck) {
         $message = '<p class="notice">Please check your password and try again.</p>';
         include '../view/login.php';
         exit;
      }
      // A valid user exists, log them in
      $_SESSION['loggedin'] = TRUE;
      // Remove the password from the array
      // the array_pop function removes the last
      // element from an array
      array_pop($clientData);
      // Store the array into the session
      $_SESSION['clientData'] = $clientData;
      // Send them to the admin view
      include '../view/admin.php';
      exit;

      break;
   case 'updateClientInfo':
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/client-update.php';
   break;
   //this is the case that actually handles the update
   case 'updateInfo':
      // Filter and store the data
      $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
      $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
      $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
      $clientEmail = checkEmail($clientEmail);
      $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);

      $existingEmail = checkEmailExists($clientEmail);
      if (($existingEmail) && !($_SESSION['clientData']['clientEmail'])) {
         $_SESSION['message'] = $message;
         $message = '<p class="notice">That email address already exists. Please enter a new email.</p>';
         include '..view/client-update.php';
      }

        // Check for missing data
        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail)) {
         $message = '<p>Please provide information for all empty form fields.</p>';
         include '../view/client-update.php';
         exit;
      }
      // Send the data to the model
         $updateResult = updateClient($clientFirstname, $clientLastname, $clientEmail, $clientId);

         // Check and report the result
         if ($updateResult === 1) {
            //query the client data from the database using a function
            $clientData = getClientInfo($clientId);
            // A valid user exists, log them in
            $_SESSION['loggedin'] = TRUE;
            // Store the array into the session
            $_SESSION['clientData'] = $clientData;
            //the message is not working!
            $message = "<p>Congratulations, the $clientFirstname account was successfully updated.</p>";
            $_SESSION['message'] = $message;
            header('Location: /phpmotors/accounts/');
            exit;
          } else {
            $message = "<p>Sorry, we were unable to update your information. Please try again.</p>";
             include '../view/client-update.php';
             exit;
            }



   break;
   case 'updatePassword':
      $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
      $checkPassword = checkPassword($clientPassword);
      $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);

            // Check for missing data
            if (empty($checkPassword)) {
               $message = '<p>Please provide information for all empty form fields.</p>';
               $_SESSION['message'] = $message;
               include '../view/client-update.php';
               exit;
            }
      
            // Hash the checked password
            $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
      
            $clientPassword = $hashedPassword;

            // Send the data to the model
            $passwordChangeOutcome = newPassword($clientPassword, $clientId);
      
      
            // Check and report the result
            if ($passwordChangeOutcome === 1) {
               $message = "<p>You successfully changed your password.</p>";
               $_SESSION['message'] = $message;
               header('Location: /phpmotors/accounts/index.php');
               exit;
            } else {
               $message = "<p>Sorry $clientFirstname, but we were unable to change your password. Please try again.</p>";
               include '../view/client-update.php';
               exit;
            }



   break;

   default:
      //dynamic page title
      $pageTitle = 'Admin';
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/admin.php';
      break;
}
