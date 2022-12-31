<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
    header('location: /phpmotors/');
    exit;
}
?><?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; ?>

<div class="form">
    <h1>
        <?php if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
            echo "Delete $invInfo[invMake] $invInfo[invModel]";
        } elseif (isset($invMake) && isset($invModel)) {
            echo "Delete $invMake $invModel";
        } ?></h1>

    <?php
    if (isset($message)) {
        echo $message;
    }
    ?>

    <form method="post" action="/phpmotors/vehicles/index.php">
    <p>Confirm Vehicle Deletion. The delete is permanent</p>
        <div class="input-border">
            <input type="text" class="text" name="invMake" id="invMake" <?php if (isset($invMake)) {
                                                                            echo "value='$invMake'";
                                                                        } elseif (isset($invInfo['invMake'])) {
                                                                            echo "value='$invInfo[invMake]'";
                                                                        } ?> readonly>
            <label for="invMake">Vehicle Make</label>
            <div class="border"></div>
        </div>

        <div class="input-border">
            <input type="text" class="text" name="invModel" id="invModel" <?php if (isset($invModel)) {
                                                                                echo "value='$invModel'";
                                                                            } elseif (isset($invInfo['invModel'])) {
                                                                                echo "value='$invInfo[invModel]'";
                                                                            } ?> readonly>
            <label for="invModel">Vehicle Model</label>
            <div class="border"></div>
        </div>

        <div class="input-border">
            <input type="text" class="text" name="invDescription" id="invDescription" <?php if (isset($invDescription)) {
                                                                                            echo "value='$invDescription'";
                                                                                        } elseif (isset($invInfo['invDescription'])) {
                                                                                            echo "value='$invInfo[invDescription]'";
                                                                                        } ?> readonly>
            <label for="invDescription">Vehicle Description</label>
            <div class="border"></div>
        </div>

        <input type="submit" class="btn" value="Delete Vehicle">

        <!-- Add the action name - value pair -->
        <input type="hidden" name="action" value="deleteVehicle">
        <input type="hidden" name="invId" value="<?php if (isset($invInfo['invId'])) {
            echo $invInfo['invId'];
        } elseif (isset($invId)) {
            echo $invId;} ?> ">
    </form>

</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>