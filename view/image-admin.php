<?php if (isset($_SESSION['message'])) {
 $message = $_SESSION['message'];
}?><?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; ?>

<h1>Image Management</h1>
<p>Welcome to the image management page. Please choose from the options below.</p>

<h2>Add New Vehicle Image</h2>
<?php
 if (isset($message)) {
  echo $message;
 } ?>

<form action="/phpmotors/uploads/" method="post" enctype="multipart/form-data" class="imageForm">
    <div class="input-border normal-border">
        <label class="normal-label" for="invId">Vehicle</label>
        <?php echo $prodSelect; ?>
        <div class="border"></div>
    </div> 
	
	<fieldset>
		<label>Is this the main image for the vehicle?</label>
		<label for="priYes" class="pImage">Yes</label>
		<input type="radio" name="imgPrimary" id="priYes" class="pImage" value="1">
		<label for="priNo" class="pImage">No</label>
		<input type="radio" name="imgPrimary" id="priNo" class="pImage" checked value="0">
	</fieldset>

    <div class="input-border normal-border">
        <label class="normal-label">Upload Image:</label>
        <input type="file" name="file1">
        <div class="border"></div>
    </div> 

        <input type="submit" class="regbtn btn" value="Upload">
        <input type="hidden" name="action" value="upload">
</form>

<hr>

<h2>Existing Images</h2>
<p class="notice">If deleting an image, delete the thumbnail too and vice versa.</p>
<?php
 if (isset($imageDisplay)) {
  echo $imageDisplay;
 } ?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>