<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
    header('location: /phpmotors/');
    exit;
}
?><?php
    //create a dynamic drop-down select list
    $classificationList = '<select name="classificationId" id="classificationId">';
    foreach ($classifications as $classification) {
        $classificationList .= "<option value='" . $classification['classificationId'] . "'";
        if (isset($classificationId)) {
            if ($classification['classificationId'] === $classificationId) {
                $classificationList .= ' selected ';
            }
        } elseif (isset($invInfo['classificationId'])) {
            if ($classification['classificationId'] === $invInfo['classificationId']) {
                $classificationList .= ' selected';
            }
        }
        $classificationList .= ">" . $classification['classificationName'] . "</option>";
    }
    $classificationList .= '</select>';

    ?><?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; ?>

<div class="form">
    <h1>
        <?php if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
            echo "Modify $invInfo[invMake] $invInfo[invModel]";
        } elseif (isset($invMake) && isset($invModel)) {
            echo "Modify$invMake $invModel";
        } ?></h1>

    <?php
    if (isset($message)) {
        echo $message;
    }
    ?>

    <form method="post" action="/phpmotors/vehicles/index.php">
        <div class="input-border">
            <input type="text" class="text" name="invMake" id="invMake" <?php if (isset($invMake)) {
                                                                            echo "value='$invMake'";
                                                                        } elseif (isset($invInfo['invMake'])) {
                                                                            echo "value='$invInfo[invMake]'";
                                                                        } ?> required>
            <label for="invMake">Vehicle Make</label>
            <div class="border"></div>
        </div>

        <div class="input-border">
            <input type="text" class="text" name="invModel" id="invModel" <?php if (isset($invModel)) {
                                                                                echo "value='$invModel'";
                                                                            } elseif (isset($invInfo['invModel'])) {
                                                                                echo "value='$invInfo[invModel]'";
                                                                            } ?> required>
            <label for="invModel">Vehicle Model</label>
            <div class="border"></div>
        </div>

        <div class="input-border">
            <input type="text" class="text" name="invDescription" id="invDescription" <?php if (isset($invDescription)) {
                                                                                            echo "value='$invDescription'";
                                                                                        } elseif (isset($invInfo['invDescription'])) {
                                                                                            echo "value='$invInfo[invDescription]'";
                                                                                        } ?> required>
            <label for="invDescription">Vehicle Description</label>
            <div class="border"></div>
        </div>

        <div class="input-border">
            <input type="text" class="text" name="invImage" id="invImage" value="/phpmotors/images/vehicles/no-image.png" placeholder="/phpmotors/images/vehicles/no-image.png" 
            <?php if (isset($invImage)) {
                 echo "value='$invImage'";
                 } elseif (isset($invInfo['invImage'])) {
                 echo "value='$invInfo[invImage]'";
                 } ?> required>
            <label class="label" for="invImage">Vehicle Image</label>
            <div class="border"></div>
        </div>

        <div class="input-border">
            <input type="text" class="text" name="invThumbnail" id="invThumbnail" value="/phpmotors/images/vehicles/no-image.png" placeholder="/phpmotors/images/vehicles/no-image.png" 
            <?php if (isset($invThumbnail)) {
                echo "value='$invThumbnail'";
                     } elseif (isset($invInfo['invThumbnail'])) {
                     echo "value='$invInfo[invThumbnail]'";
                     } ?> required>
            <label class="label" for="invThumbnail">Vehicle Thumbnail</label>
            <div class="border"></div>
        </div>

        <div class="input-border">
            <input type="number" class="text" name="invPrice" id="invPrice" <?php if (isset($invPrice)) {
                                                                                echo "value='$invPrice'";
                                                                            } elseif (isset($invInfo['invPrice'])) {
                                                                                echo "value='$invInfo[invPrice]'";
                                                                            } ?> required>
            <label for="invPrice">Vehicle Price</label>
            <div class="border"></div>
        </div>

        <div class="input-border">
            <input type="number" class="text" name="invStock" id="invStock" <?php if (isset($invStock)) {
                                                                                echo "value='$invStock'";
                                                                            } elseif (isset($invInfo['invStock'])) {
                                                                                echo "value='$invInfo[invStock]'";
                                                                            } ?> required>
            <label for="invStock">How many vehicles are there?</label>
            <div class="border"></div>
        </div>

        <div class="input-border">
            <input type="text" class="text" name="invColor" id="invColor" <?php if (isset($invColor)) {
                                                                                echo "value='$invColor'";
                                                                            } elseif (isset($invInfo['invColor'])) {
                                                                                echo "value='$invInfo[invColor]'";
                                                                            } ?> required>
            <label for="invColor">Vehicle Color</label>
            <div class="border"></div>
        </div>

        <div class="input-border normal-border">
            <label class="normal-label" for="classificationId">Vehicle Classification</label>
            <?php echo $classificationList ?>
            <div class="border"></div>
        </div>

        <input type="submit" class="btn" value="Update Vehicle">

        <!-- Add the action name - value pair -->
        <input type="hidden" name="action" value="updateVehicle">
        <input type="hidden" name="invId" value="<?php if (isset($invInfo['invId'])) {
            echo $invInfo['invId'];
        } elseif (isset($invId)) {
            echo $invId;} ?> ">
    </form>

</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
