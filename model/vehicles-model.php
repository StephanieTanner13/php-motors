<?php

/*
* Vehicles Model
*/


//add a new classification into the carclassifications table
function addCarClassification($classificationName){
    //create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    //sql statement
    $sql = 'INSERT INTO carclassification (classificationName)
    VALUES (:classificationName)';
    //create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    //The next line replaces the placeholders in the sql statement
    //with the actual values in the variables
    //and tells the database the type of data it is
    $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
    //insert the data
    $stmt->execute();
    //ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    //Close the database interaction
    $stmt->closeCursor();
    //return the indication of success (rows changed)
    return $rowsChanged;
}
//add a new vehicle into the inventory table
function addVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId){
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    //the SQL statement
    $sql = 'INSERT INTO inventory (invMake, invModel, invDescription, invImage, invThumbnail, invPrice, invStock, invColor, classificationId)
    VALUES (:invMake, :invModel, :invDescription, :invImage, :invThumbnail, :invPrice, :invStock, :invColor, :classificationId)';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // The next lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
    $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
    $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
    $stmt->bindValue(':invStock', $invStock, PDO::PARAM_STR);
    $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_STR);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}


//the following is used in the vehicles controller getInventoryItems case statement
// Get vehicles by classificationId 
function getInventoryByClassification($classificationId){ 
    $db = phpmotorsConnect(); 
    $sql = ' SELECT * FROM inventory WHERE classificationId = :classificationId'; 
    $stmt = $db->prepare($sql); 
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT); 
    $stmt->execute(); 
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 
    return $inventory; 
   }

//the following is used in the vehicle controller mod case statement
// Get vehicle information by invId
function getInvItemInfo($invId){
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $invInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $invInfo;
   }

//update a vehicle in the vehicle-update.php view and update the inventory table
function updateVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId, $invId){
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    //the SQL statement
    $sql = 'UPDATE inventory SET invMake = :invMake, invModel = :invModel, invDescription = :invDescription, invImage = :invImage, invThumbnail = :invThumbnail, invPrice = :invPrice, invStock = :invStock, invColor = :invColor, classificationId = :classificationId WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    // The next lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
    $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
    $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
    $stmt->bindValue(':invStock', $invStock, PDO::PARAM_STR);
    $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_STR);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}

//DELETE a vehicle in the vehicle-update.php view and update the inventory table
function deleteVehicle($invId){
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    //the SQL statement
    $sql = 'DELETE FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    // The next lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}

//JOIN images ON inventory.invId = images.invId
//Get a list of vehicles based on the classification for the Nav bar pages
function getVehiclesByClassification($classificationName){
    $db = phpmotorsConnect();
    $sql = 'SELECT inventory.*, images.* FROM inventory 
            JOIN images ON images.invId = inventory.invId 
            WHERE classificationId IN (SELECT classificationId FROM carclassification WHERE classificationName = :classificationName) 
            AND images.imgPrimary = 1 
            AND images.imgName LIKE "%-tn.%"';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
    $stmt->execute();
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $vehicles;
   }

   //the following function is used in the uploads index.php
   // Get information for all vehicles
    function getVehicles(){
	    $db = phpmotorsConnect();
	    $sql = 'SELECT invId, invMake, invModel FROM inventory';
	    $stmt = $db->prepare($sql);
	    $stmt->execute();
	    $invInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
	    $stmt->closeCursor();
        return $invInfo;
    }

    //Get image thumbnails
    function getImageThumbnails($invId){
        $db = phpmotorsConnect();
	    $sql = 'SELECT * FROM images WHERE invId = :invId AND imgPath LIKE "%-tn.%"';
	    $stmt = $db->prepare($sql);
        $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
	    $stmt->execute();
	    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	    $stmt->closeCursor();
        return $result;
    }