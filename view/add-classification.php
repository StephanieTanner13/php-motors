<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
 header('location: /phpmotors/');
 exit;
}
?><?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; ?>

<div class="form">
  <h1>Add Car Classification</h1>

  <?php
  if (isset($message)) {
    echo $message;
  }
  ?>

  <form method="post" action="/phpmotors/vehicles/index.php">
    <div class="input-border">
      <input type="text" class="text" name="classificationName" id="classificationName" required>
      <label for="classificationName">Classification Name</label>
      <div class="border"></div>
    </div>

    <input type="submit" class="btn" value="Add Classification">

    <!-- Add the action name - value pair -->
    <input type="hidden" name="action" value="addClassification">
  </form>

</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>