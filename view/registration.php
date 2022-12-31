<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; ?>

<div class="form">
  <h1>Register for PHP Motors</h1>

  <?php
  if (isset($message)) {
    echo $message;
  }
  ?>

  <form method="post" action="/phpmotors/accounts/index.php">
    <div class="input-border">
      <input type="text" class="text" name="clientFirstname" id="clientFirstname" <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";}  ?> required>
      <label for="clientFirstname">First Name</label>
      <div class="border"></div>
    </div>

    <div class="input-border">
      <input type="text" class="text" name="clientLastname" id="clientLastname" <?php if(isset($clientLastname)){echo "value='$clientlastname'";}  ?> required>
      <label for="clientLastname">Last Name</label>
      <div class="border"></div>
    </div>

    <div class="input-border">
      <input type="email" class="text" name="clientEmail" id="clientEmail" <?php if(isset($clientEmail)){echo "value='$clientEmail'";}  ?> required>
      <label for="clientEmail">Email</label>
      <div class="border"></div>
    </div>

    <div class="input-border">
      <input type="password" class="text" name="clientPassword" id="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
      <span>*make sure the password is at least 8 characters and has at least 1 uppercase character,
      1 number, and 1 special character.</span>
      <label for="clientPassword">Password</label>
      <div class="border"></div>
    </div>

    <input type="submit" class="btn" value="Register">

    <!-- Add the action name - value pair -->
    <input type="hidden" name="action" value="register">
  </form>

</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>