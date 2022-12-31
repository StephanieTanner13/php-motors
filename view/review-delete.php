<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; ?>

<div class="form">
    <h1>Delete a Review</h1>

    <?php
    if (isset($message)) {
        echo $message;
    }
    ?>
<p>Deleting Your Review is permanent</p>
    <form method="post" action="/phpmotors/reviews/index.php">
        <div class="input-border">
            <input type="text" class="text" name="reviewText" id="reviewText" 
            <?php if (isset($reviewText)) {
                    echo "value='$reviewText'";
                } elseif (isset($reviewInformation['reviewText'])) {
                    echo "value='$reviewInformation[reviewText]'";
             } ?> 
             required readonly>
            <label for="reviewText" class="normal-label">Delete Your Review</label>
            <div class="border"></div>
        </div>


        <input type="submit" class="btn" value="Delete Your Review">

        <!-- Add the action name - value pair -->
        <input type="hidden" name="action" value="deleteReview">
        <input type="hidden" name="reviewId" value="<?php echo $reviewInformation['reviewId'] ?> ">
    </form>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
