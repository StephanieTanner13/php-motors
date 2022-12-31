<?php if (!$_SESSION['loggedin']){
    header('Location: /phpmotors/index.php');
    exit;
}
?><?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; ?>

<h1><?php 
//display the users full name when signed in
echo $_SESSION['clientData']['clientFirstname'] . " " . $_SESSION['clientData']['clientLastname']?></h1>

<?php
  $message = $message ?? (isset($_SESSION['message'])? $_SESSION['message']:null);
  if (isset($message)) {
    echo $message;
  }
  ?>

<p>You are logged in.</p>
<ul>
    <li>First name: <span><?php echo $_SESSION['clientData']['clientFirstname']?></span></li>
    <li>Last name: <span><?php echo $_SESSION['clientData']['clientLastname']?></span></li>
    <li>Email Address: <span><?php echo $_SESSION['clientData']['clientEmail']?></span></li>
</ul>

<h2>Account Management</h2>
<p>Use this link to update account information</p>
<?php $accountControlLink = "<p><a href='/phpmotors/accounts/index.php?action=updateClientInfo' title='Make changes to your account'>";
        $accountControlLink .= "Update Your Account Information</a></p>";
        echo $accountControlLink;
?>
<?php 
if ($_SESSION['clientData']['clientLevel'] > 1){
    $vehicleControlHeading = "<h2>Inventory Management</h2><p>Use this link to manage the inventory</p>";
    $vehicleControllerLink = "<p>" . "<a href='/phpmotors/vehicles/index.php' title='Admin access to add vehicles'>";
    $vehicleControllerLink .= "Add Vehicles and Classifications";
    $vehicleControllerLink .= "</a></p>";

    echo $vehicleControlHeading;
    echo $vehicleControllerLink;
}
?>

<h2>Your Vehicle Reviews</h2>
<?php

//create a list of the reviews from the database.
$existingReviews = specificClientReviews($_SESSION['clientData']['clientId']);

$rs = "<div class='review'>";
foreach (array_reverse($existingReviews) as $review){
  $rs .= '<div class="singleReview">';
  //car that you reviewed
  $rs .= '</h4>';
  $rs .= $review['invMake']. ' ' . $review['invModel'];
  $rs .= '</h4>';
  //review text
  $rs .= '<p>';
  $rs .= $review['reviewText'];
  $rs .= '</p>';
  //review date using the database timestamp and formating it
  $rs .= '<p>Reviewed on ';
  $rs .= date('jS F, Y', strtotime($review['reviewDate']));
  $rs .= '</p>';
  $rs .= '<p>';
  $rs .= '<a href="/phpmotors/reviews/index.php?action=deleteView&reviewId=' . $review['reviewId'] . '">Delete Review</a>';
  $rs .= ' | ';
  $rs .= '<a href="/phpmotors/reviews/index.php?action=updateView&reviewId=' . $review['reviewId'] . '">Update Review</a>';
  $rs .= '</p>';
  $rs .= '</div>';
}
$rs .= "</div>";

echo $rs;
?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>

