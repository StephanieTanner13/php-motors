<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
 header('location: /phpmotors/');
 exit;
}
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
   }
?><?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; ?>

<h1>Vehicle Management</h1>
<?php
//link to go to the add-classification page
$addClassificationPageLink = "<a href='/phpmotors/vehicles/index.php?action=addClassificationView' title='Add a New Car Classification'>";
$addClassificationPageLink .= "Add Car Classification";
$addClassificationPageLink .= "</a>";

//link to go to the add-vehicle page
$addVehiclePageLink = "<a href='/phpmotors/vehicles/index.php?action=addVehicleView' title='Add a New Vehicle'>";
$addVehiclePageLink .= "Add Vehicle";
$addVehiclePageLink .= "</a>";
?>
<ul>
    <li><?php echo $addClassificationPageLink ?></li>
    <li><?php echo $addVehiclePageLink ?></li>
</ul>

<?php
if (isset($message)) { 
 echo $message; 
} 
if (isset($classificationList)) { 
 echo '<h2>Vehicles By Classification</h2>'; 
 echo '<p>Choose a classification to see those vehicles</p>'; 
 echo $classificationList; 
}
?>
<noscript>
<p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
</noscript>
<table id="inventoryDisplay"></table>


<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>