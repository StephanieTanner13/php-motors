<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; ?>

<h1><?php echo $invInfo['invMake'] . " | " . $invInfo['invModel'] ?></h1>

<?php
  $message = $message ?? (isset($_SESSION['message'])? $_SESSION['message']:null);
  if (isset($message)) {
    echo $message;
  }
  ?>
  
<?php if(isset($vehiclePage)){
    echo $vehiclePage;
} ?>

<hr>
<h2>Customer Reviews</h2>
<!-- If the customer is not logged in, let them know they can log in to make a review -->
<?php if (isset($_SESSION['loggedin'])){ 
  echo '<p class="center">Add a customer review by filling out the form below</p>';
  } else{
    echo '<a href="/phpmotors/accounts/index.php?action=loginView">Log in</a> to add a review';
  }  ?>

<?php if(isset($_SESSION['loggedin'])) : ?>
  <div class="form">
    <h2>Write a Review</h2>

    <?php
    if (isset($message)) {
        echo $message;
    }
    ?>

    <form method="post" action="/phpmotors/reviews/index.php">
    <div class="input-border">
            <p><?php echo substr($name = $_SESSION['clientData']['clientFirstname'], 0, 1) . $_SESSION['clientData']['clientLastname'];
             ?></p>
            <div class="border"></div>
        </div>
        <div class="input-border">
            <input type="text" class="text" name="reviewText" id="reviewText" 
            <?php if (isset($reviewText)) {
                    echo "value='$reviewText'";
                } elseif (isset($invInfo['reviewText'])) {
                    echo "value='$invInfo[reviewText]'";
             } ?> 
             required>
            <label for="reviewText">Write your Review</label>
            <div class="border"></div>
        </div>


        <input type="submit" class="btn" value="Submit Your Review">

        <!-- Add the action name - value pair -->
        <input type="hidden" name="action" value="newReview">
        <input type="hidden" name="invId" value="<?php if (isset($invInfo['invId'])) {
            echo $invInfo['invId'];
        } elseif (isset($invId)) {
            echo $invId;} ?>">
            <input type="hidden" name="clientId" value="<?php if (isset($_SESSION['clientData']['clientId'])) {
            echo $_SESSION['clientData']['clientId'];
        } elseif (isset($clientId)) {
            echo $clientId;} ?>">
    </form>
</div>
<?php endif; ?>

<?php

//create a list of the reviews from the database.
$existingReviews = getClientReviewsForInventoryItem($invId);

$rs = "<div class='review'>";
foreach (array_reverse($existingReviews) as $review){
  $rs .= '<div class="singleReview">';
  $rs .= '<h3>';
  //Get the screen name to display with the review
  $screenName = substr($review['clientFirstname'], 0, 1) . $review['clientLastname'];
  $rs .= $screenName;
  $rs .= '</h3>';
  //review text
  $rs .= '<p>';
  $rs .= $review['reviewText'];
  $rs .= '</p>';
  //review date using the database timestamp and formating it
  $rs .= '<p>';
  $rs .= date('jS F, Y', strtotime($review['reviewDate']));
  $rs .= '</p>';
  $rs .= '</div>';
}
$rs .= "</div>";

echo $rs;
?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>

