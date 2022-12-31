<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="UTF-8">
    <title>
        <?php if (isset($pageTitle)) echo $pageTitle ?> | PHP Motors
    </title>
    <link href="/phpmotors/css/styles.css" type="text/css" rel="stylesheet" media="screen">
    <meta name="viewport" content="width=device-width, initial scale=1.0">
</head>

<body>
    <header>
        <img src="/phpmotors/images/site/logo.png" alt=" PHP Motors Logo">
        <div>
            <?php if (isset($_SESSION['loggedin'])) {
                //link to the admin page and the welcome message created by the session
                $welcomeLinkToAdmin = "<a href='/phpmotors/accounts/index.php' title='Go to your Admin page when signed in'>";
                $welcomeLinkToAdmin .= "Welcome " . $_SESSION['clientData']['clientFirstname'];
                $welcomeLinkToAdmin .= "</a>";

                echo $welcomeLinkToAdmin;
                //echo "Welcome " . $_SESSION['clientData']['clientFirstname'];

                //logout link
                $logout = "<a href='/phpmotors/accounts/index.php?action=Logout'>Logout</a>";

                echo $logout;
            } else {
                //link the My Accounts to the login page
                $loginPageLink = "<a href='/phpmotors/accounts/index.php?action=loginView' title='Login or Register for your Account' class='register-link'>";
                $loginPageLink .= "My Account";
                $loginPageLink .= "</a>";
                echo $loginPageLink;
            }

            ?>
        </div>
    </header>
    <nav>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/nav.php'; ?>
    </nav>
    <main>