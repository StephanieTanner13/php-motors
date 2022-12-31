<?php if (!$_SESSION['loggedin']){
    header('Location: /phpmotors/index.php');
    exit;
}
?><?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; ?>
<h1>
        <?php echo "Update " . $_SESSION['clientData']['clientFirstname'];?></h1>
<?php
  if (isset($message)) {
    echo $message;
  }
  ?>

<div class="form">
  <h2>Update Your Information</h2>

  <form method="post" action="/phpmotors/accounts/index.php">
    <div class="input-border">
      <input type="text" class="text" name="clientFirstname" id="clientFirstname"
       <?php 
       if(isset($clientFirstname)){
           echo "value='$clientFirstname'";
       }
        elseif (isset($_SESSION['clientData']['clientFirstname'])) 
        {
         echo "value=" . $_SESSION['clientData']['clientFirstname']; } ?> required>

      <label class="normal-label" for="clientFirstname">First Name</label>
      <div class="border"></div>
    </div>

    <div class="input-border">
      <input type="text" class="text" name="clientLastname" id="clientLastname" 
      <?php 
       if(isset($clientLastname)){
           echo "value='$clientLastname'";
       }
        elseif (isset($_SESSION['clientData']['clientLastname'])) 
        {
         echo "value=" . $_SESSION['clientData']['clientLastname']; } ?> required>
      <label class="normal-label" for="clientLastname">Last Name</label>
      <div class="border"></div>
    </div>

    <div class="input-border">
      <input type="email" class="text" name="clientEmail" id="clientEmail" 
      <?php 
       if(isset($clientFirstname)){
           echo "value='$clientFirstname'";
       }
        elseif (isset($_SESSION['clientData']['clientEmail'])) 
        {
         echo "value=" . $_SESSION['clientData']['clientEmail']; } ?> required>
      <label class="normal-label" for="clientEmail">Email</label>
      <div class="border"></div>
    </div>

    <input type="submit" class="btn" value="Update Information">

    <!-- Add the action name - value pair -->
    <input type="hidden" name="action" value="updateInfo">
    <input type="hidden" name="clientId" value="<?php if (isset($clientId)){
        echo $clientId;
    } 
    elseif (isset($_SESSION['clientData']['clientId'])){
        echo $_SESSION['clientData']['clientId'];} ?>">
  </form>

</div>

<?php
  if (isset($message)) {
    echo $message;
  }
  ?>

<div class="form">
  <h2>Change Your Password</h2>
  <p>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter,
  and 1 special character.</p>

  <p>Your original password will be changed.</p>

  <form method="post" action="/phpmotors/accounts/index.php">

    <div class="input-border">
      <input type="password" class="text" name="clientPassword" id="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">

      <label for="clientPassword">Password</label>
      <div class="border"></div>
    </div>

    <input type="submit" class="btn" value="Change Password">

    <!-- Add the action name - value pair -->
    <input type="hidden" name="action" value="updatePassword">
    <input type="hidden" name="clientId" value="<?php if (isset($clientId)){
        echo $clientId;
    } 
    elseif (isset($_SESSION['clientData']['clientId'])){
        echo $_SESSION['clientData']['clientId'];} ?>">
  </form>

</div>


<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>