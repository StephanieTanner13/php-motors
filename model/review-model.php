<?php

/* Review model to handle all database functionality */

//insert a review
function addReview($reviewText, $invId, $clientId){
    //create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    //sql statement
    $sql = 'INSERT INTO reviews (reviewText, invId, clientId) 
    VALUES (:reviewText, :invId, :clientId)';
    //create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    //replace the placeholders in the SQL statement with the actual variable values
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    //insert the data
    $stmt->execute();
    //ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    //close the database interaction
    $stmt->closeCursor();
    //Return indication of success (rows changed)
    return $rowsChanged;
}

//get reviews for a specific inventory item with the client information
function getClientReviewsForInventoryItem($invId){
    $db = phpmotorsConnect();
    $sql = 'SELECT reviews.*, clients.* FROM reviews JOIN clients ON reviews.clientId = clients.clientId WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $clientReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $clientReviews;
}

//get reviews for a specific inventory item
//This one is currently not being used. I will keep it just in case until the end
function getReviewsForInventoryItem($invId){
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM reviews WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $existingReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $existingReviews;
}

//get reviews written by a specific client
function specificClientReviews($clientId){
    $db = phpmotorsConnect();
    $sql = 'SELECT reviews.*, inventory.* FROM reviews JOIN inventory ON reviews.invId = inventory.invId WHERE clientId = :clientId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    $clientReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $clientReviews;
}

//get a specific review
function specificReview($reviewId){
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM reviews WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $specificReview = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $specificReview;
}

//update a specific review
function updateReview($reviewId, $reviewText){
    $db = phpmotorsConnect();
    $sql = 'UPDATE reviews SET reviewText = :reviewText WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    //replace the placeholders in the SQL statement with the actual variable values
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    //insert the data
    $stmt->execute();
    //ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    //close the database interaction
    $stmt->closeCursor();
    //Return indication of success (rows changed)
    return $rowsChanged;
}

//delete a specific review
function deleteReview($reviewId){
        // Create a connection object using the phpmotors connection function
        $db = phpmotorsConnect();
        //the SQL statement
        $sql = 'DELETE FROM reviews WHERE reviewId = :reviewId';
        $stmt = $db->prepare($sql);
        //replace the placeholders in the SQL
        $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
        // Insert the data
        $stmt->execute();
        // Ask how many rows changed as a result of our insert
        $rowsChanged = $stmt->rowCount();
        // Close the database interaction
        $stmt->closeCursor();
        // Return the indication of success (rows changed)
        return $rowsChanged;
}