<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
 header('location: /phpmotors/');
 exit;
}
?><?php 
//create a dynamic drop-down select list
$classificationList = '<select name="classificationId" id="classificationId" required>';
foreach ($classifications as $classification) {
    $classificationList .= "<option value='" . $classification['classificationId'] . "'";
    if(isset($classificationId)){
      if($classification['classificationId'] === $classificationId){
        $classificationList .= ' selected ';
      }
    }
    $classificationList .= ">" . $classification['classificationName'] . "</option>";
}
$classificationList .= '</select>';

?><?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; ?>

<div class="form">
  <h1>Add A Vehicle</h1>

  <?php
  if (isset($message)) {
    echo $message;
  }
  ?>

  <form method="post" action="/phpmotors/vehicles/index.php">
    <div class="input-border">
      <input type="text" class="text" name="invMake" id="invMake" 
        <?php if(isset($invMake)){echo "value='$invMake'";}  ?> required>
      <label for="invMake">Vehicle Make</label>
      <div class="border"></div>
    </div>

    <div class="input-border">
      <input type="text" class="text" name="invModel" id="invModel" 
        <?php if(isset($invModel)){echo "value='$invModel'";}  ?>  required>
      <label for="invModel">Vehicle Model</label>
      <div class="border"></div>
    </div>

    <div class="input-border">
      <input type="text" class="text" name="invDescription" id="invDescription" 
         <?php if(isset($invDescription)){echo "value='$invDescription'";}  ?> required>
      <label for="invDescription">Vehicle Description</label>
      <div class="border"></div>
    </div>

    <div class="input-border">
      <input type="text" class="text" name="invImage" id="invImage" value="/phpmotors/images/vehicles/no-image.png" 
        placeholder="/phpmotors/images/no-image.png" 
        <?php if(isset($invImage)){echo "value='$invImage'";}  ?> required>
      <label class="label" for="invImage">Vehicle Image</label>
      <div class="border"></div>
    </div>

    <div class="input-border">
      <input type="text" class="text" name="invThumbnail" id="invThumbnail" value="/phpmotors/images/vehicles/no-image.png" 
        placeholder="/phpmotors/images/no-image.png"
        <?php if(isset($invThumbnail)){echo "value='$invThumbnail'";}  ?> required>
      <label class="label" for="invThumbnail">Vehicle Thumbnail</label>
      <div class="border"></div>
    </div>

    <div class="input-border">
      <input type="number" class="text" name="invPrice" id="invPrice" 
        <?php if(isset($invPrice)){echo "value='$invPrice'";}  ?> required>
        <label for="invPrice">Vehicle Price</label>
      <div class="border"></div>
    </div>

    <div class="input-border">
      <input type="number" class="text" name="invStock" id="invStock" 
        <?php if(isset($invStock)){echo "value='$invStock'";}  ?> required>
        <label for="invStock">How many vehicles are there?</label>
      <div class="border"></div>
    </div>

    <div class="input-border">
      <input type="text" class="text" name="invColor" id="invColor" 
        <?php if(isset($invColor)){echo "value='$invColor'";}  ?> required>
      <label for="invColor">Vehicle Color</label>
      <div class="border"></div>
    </div>

    <div class="input-border normal-border">
    <label class="normal-label" for="classificationId">Vehicle Classification</label>
    <?php echo $classificationList ?>
      <div class="border"></div>
    </div>

    <input type="submit" class="btn" value="Add a Vehicle">

    <!-- Add the action name - value pair -->
    <input type="hidden" name="action" value="addVehicle">
  </form>

</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>