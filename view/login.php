<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; ?>

<div class="form">
    <h1>Login to PHP Motors</h1>

    <?php
    if (isset($_SESSION['message'])){
        echo $_SESSION['message'];
    }
    ?>

    <form action="/phpmotors/accounts/index.php" method="post">
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

        <input type="submit" class="btn" value="Login">
        <input type="hidden" name="action" value="Login">

        <br><?php echo $registrationPage ?>
    </form>

</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>