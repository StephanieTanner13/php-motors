<?php

/*Reviews Controller*/

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
//get the review model
require_once '../model/review-model.php';


//dynamic page title
$pageTitle = 'Reviews';

// Build a navigation bar from the functions file
$navList = navigation();

// Get the array of classifications
$classifications = getClassifications();

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
   $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
    case 'newReview':
        //add a new review
        //filter and store the data
        $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);

        //check for missing data
        if (empty($reviewText) || empty($invId) || empty($clientId)){
            $message = '<p>Please provide information for all empty form fields.</p>';
            //change the include to the real page... probably the vehicle page
            include '../view/vehicle-detail.php';
            exit;
        }
        
        //send the data to the model
        $reviewOutcome = addReview($reviewText, $invId, $clientId);

        // Check and report the result
        if ($reviewOutcome === 1) {
            $message = "<p>Thanks for adding a new review.</p>";
            //change the include to the real page... probably the vehicle page
                header('Location: /phpmotors/vehicles/index.php?action=vehicleInformation&invId=' . $invId );
                include '../view/vehicle-detail.php';
                exit;
            } else {
                $message = "<p>Sorry, we were unable to add your review. Please try again.</p>";
                //change the include to the real page... probably the vehicle page
                include '../view/vehicle-detail.php';
                exit;
            }
    break;
    case 'updateView':
        //deliver a view to update a review
        $pageTitle = 'Update a Review';
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_VALIDATE_INT);

        $reviewInformation = specificReview($reviewId);

        if (!isset($reviewInformation)) {
            $message = 'Sorry, no review information could be found.';
        }

        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/review-update.php';
    break;
    case 'updateReview':
        //handle the review update
        //filter and store the data
        $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
        $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);

        //check for missing data
        if (empty($reviewText) || empty($reviewId)){
            $message = '<p>Please provide new review text.</p>';
            include 'phpmotors/reviews/index.php?action=updateView&reviewId=' . $reviewId;
            exit;
        }

        //send the data to the model
        $updateResult = updateReview($reviewId, $reviewText);

        // Check and report the result
        if ($updateResult === 1) {
            $message = "<p>Congratulations, your review was successfully updated.</p>";
            $_SESSION['message'] = $message;
            header('Location: /phpmotors/accounts/index.php');
            exit;
        } else {
            $message = "<p>Sorry, we were unable to update the review. Please try again.</p>";
            include 'phpmotors/reviews/index.php?action=updateView&reviewId=' . $reviewId;
            exit;
        }
    break;
    case 'deleteView':
        //deliver the view to confirm deletion of a review
        $pageTitle = 'Delete a Review';
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_VALIDATE_INT);

        $reviewInformation = specificReview($reviewId);

        if (!isset($reviewInformation)) {
            $message = 'Sorry, no review information could be found.';
        }
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/review-delete.php';
    break;
    case 'deleteReview':
        //handle the review deletion
        $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);

        // Send the data to the model
        $deleteResult = deleteReview($reviewId);

        if ($deleteResult === 1) {
            $message = "<p>Congratulations, the review was deleted.</p>";
            $_SESSION['message'] = $message;
            header('Location: /phpmotors/accounts/index.php');
            exit;
        } else {
            $message = "<p>Sorry, we were unable to delete the review. Please try again.</p>";
            $_SESSION['message'] = $message;
            include '/phpmotors/vehicles/index.php?action=deleteReview&reviewId=' . $reviewId;
            exit;
        }
    break;
    default:
        //deliver the admin view if the client is logged in or the php motors home view if not logged in
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/accounts/index.php';
    break;
 }