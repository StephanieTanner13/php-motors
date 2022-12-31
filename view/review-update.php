<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; ?>

<div class="form">
    <h1>Update a Review</h1>

    <?php
    if (isset($message)) {
        echo $message;
    }
    ?>

    <form method="post" action="/phpmotors/reviews/index.php">
        <div class="input-border">
            <input type="text" class="text" name="reviewText" id="reviewText" 
            <?php if (isset($reviewText)) {
                    echo "value='$reviewText'";
                } elseif (isset($reviewInformation['reviewText'])) {
                    echo "value='$reviewInformation[reviewText]'";
             } ?> 
             required>
            <label for="reviewText">Write your Review</label>
            <div class="border"></div>
        </div>


        <input type="submit" class="btn" value="Submit Your Review">

        <!-- Add the action name - value pair -->
        <input type="hidden" name="action" value="updateReview">
        <input type="hidden" name="reviewId" value="<?php echo $reviewInformation['reviewId'] ?> ">
    </form>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
