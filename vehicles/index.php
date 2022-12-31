<?php

//create or access a SESSION
if (!isset($_SESSION)){
    session_start();
 }

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
//get the accounts model for use as needed
require_once '../model/vehicles-model.php';
//get the functions file  for use as needed
require_once '../library/functions.php';
//get the review model for use when adding reviews to the page
require_once '../model/review-model.php';

//dynamic page title
$pageTitle = 'Vehicles';

// Build a navigation bar from the functions file
$navList = navigation();

// Get the array of classifications
$classifications = getClassifications();

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}


switch ($action) {
        //I can test this case by typing localhost/phpmotors/?action=addClassificationView into the browser
    case 'addClassificationView':
        //dynamic page title
        $pageTitle = 'Classification Admin';
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-classification.php';
        break;
    case 'addVehicleView':
        //dynamic page title
        $pageTitle = 'Vehicle Admin';
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-vehicle.php';
        break;
        //case to utilize the form to add a vehicle
    case 'addVehicle':
        // Filter and store the data
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
        $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING);
        $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_STRING);


        // Check for missing data
        if (empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor) || empty($classificationId)) {
            $message = '<p>Please provide information for all empty form fields.</p>';
            include '../view/add-vehicle.php';
            exit;
        }

        // Send the data to the model
        $vehicleOutcome = addVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId);


        // Check and report the result
        if ($vehicleOutcome === 1) {
            $message = "<p>Thanks for adding a new vehicle.</p>";
            include '../view/add-vehicle.php';
            exit;
        } else {
            $message = "<p>Sorry, we were unable to add your vehicle. Please try again.</p>";
            include '../view/add-vehicle.php';
            exit;
        }

        break;

        //case to utilize the form to add a car classification
    case 'addClassification':
        // Filter and store the data
        $classificationName = filter_input(INPUT_POST, 'classificationName');

        // Check for missing data
        if (empty($classificationName)) {
            $message = '<p>Please provide a new classification name</p>';
            include '../view/add-classification.php';
            exit;
        }

        // Send the data to the model
        $classificationOutcome = addCarClassification($classificationName);


        // Check and report the result
        if ($classificationOutcome === 1) {
            header('Location: /phpmotors/vehicles/index.php');
            exit;
        } else {
            $message = "<p>Sorry, we were unable to add your classification. Please try again.</p>";
            include '../view/add-classification.php';
            exit;
        }

        break;
        /* * ********************************** 
    * Get vehicles by classificationId 
     * Used for starting Update & Delete process 
     * ********************************** */
    case 'getInventoryItems':
        // Get the classificationId 
        $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        // Fetch the vehicles by classificationId from the DB 
        $inventoryArray = getInventoryByClassification($classificationId);
        // Convert the array to a JSON object and send it back 
        echo json_encode($inventoryArray);
        break;
    case 'mod':
            //form info and message
        $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);

        if (count($invInfo) < 1) {
            $message = 'Sorry, no vehicle information could be found.';
        }

         //dynamic title
        if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
            $pageTitle = "Modify $invInfo[invMake] $invInfo[invModel]";
        } 
        elseif(isset($invMake) && isset($invModel)) { 
            $pageTitle = "Modify $invMake $invModel"; 
        };

        include '../view/vehicle-update.php';
        exit;
        break;
    case 'updateVehicle';
        // Filter and store the data
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
        $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING);
        $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_STRING);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);


        // Check for missing data
        if (empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor) || empty($classificationId)) {
            $message = '<p>Please provide information for all empty form fields.</p>';
            include '../view/vehicle-update.php';
            exit;
        }

        // Send the data to the model
        $updateResult = updateVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId, $invId);


        // Check and report the result
        if ($updateResult === 1) {
            $message = "<p>Congratulations, the $invMake $invModel was successfully updated.</p>";
            $_SESSION['message'] = $message;
            header('Location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p>Sorry, we were unable to update the vehicle. Please try again.</p>";
            include '../view/vehicle-update.php';
            exit;
        }
    break;
    case 'del':
            //form info and message to get the right vehicle displayed
            $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            $invInfo = getInvItemInfo($invId);
    
             //dynamic title
            if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
                $pageTitle = "Delete $invInfo[invMake] $invInfo[invModel]";
            } 
            elseif(isset($invMake) && isset($invModel)) { 
                $pageTitle = "Delete $invMake $invModel"; 
            };
            
            if (count($invInfo) < 1) {
                $message = 'Sorry, no vehicle information could be found.';
            }
    
            include '../view/vehicle-delete.php';


        break;
    case 'deleteVehicle';
        // Filter and store the data
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);


        // Send the data to the model
        $deleteResult = deleteVehicle($invId);
        // Check and report the result
        if ($deleteResult === 1) {
            $message = "<p>Congratulations, the $invMake $invModel was successfully deleted.</p>";
            $_SESSION['message'] = $message;
            header('Location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p>Sorry, we were unable to delete the $invMake $invModel. Please try again.</p>";
            $_SESSION['message'] = $message;
            header('Location: /phpmotors/vehicles/');
            exit;
        }
    break;
    case 'classification':
        $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_STRING);
        
        //dynamic page title
        $pageTitle = $classificationName;

        
        $vehicles = getVehiclesByClassification($classificationName);
        if(!count($vehicles)){
         $message = "<p class='notice'>Sorry, no $classificationName could be found.</p>";
        } else {
         $vehicleDisplay = buildVehiclesDisplay($vehicles);
        }
        include '../view/classification.php';

    break;
    case 'vehicleInformation':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        
         $invInfo = getInvItemInfo($invId);

        //dynamic page title
        $pageTitle =  $invInfo['invMake'] . " | " . $invInfo['invModel'];

        if(empty($invInfo)){
         $message = "<p class='notice'>Sorry, no vehicle could be found.</p>";
         include '../view/classification.php'; 
        } else {
         $vehiclePage = buildVehiclePage($invInfo);
         include '../view/vehicle-detail.php';
        }

    
    break;
    default:
        $classificationList = buildClassificationList($classifications);
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/vehicle-man.php';
        break;
}
