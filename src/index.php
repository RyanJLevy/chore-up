<?php
session_start();
require "./config/config.php";

if ( isset($_POST['username']) && isset($_POST['password']) ) {
    if ( empty($_POST['username']) || empty($_POST['password']) ) {
        $error = "Please enter username and password";
    }
    else {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($mysqli->connect_errno) {
            echo $mysqli->connect_error;
            exit();
        }

        $passwordInput = hash("sha256", $_POST['password']);
        $prepared = $mysqli->prepare("SELECT * FROM users WHERE username=? AND password=?");
        $prepared->bind_param("ss", $_POST['username'], $passwordInput);

        $executed = $prepared->execute();
        if (!$executed) {
            echo $mysqli->error;
            exit();
        }

        $prepared->store_result();
	    $numrows = $prepared->num_rows();

        if ($numrows > 0) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $_POST['username'];
            // Redirect the user to the homepage
            header("Location: ./home.php");
        }
        else {
            $error = "Invalid username or password";
        }

        $prepared->close();
        $mysqli->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>choreUP | Login</title>
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="./styles/login.css">

</head>
<body>
    <?php include "nav.php"; ?>
    <div id="page-container">
        <div id="login-container">
            <form action="index.php" method="POST">
                <h1>login</h1>
                <div id="field-container">
                    <p>username</p>
                    <input type="text" class="form-input" id="username-input" name="username" placeholder="enter your username">
                    <p>password</p>
                    <input type="password" class="form-input" id="password-input" name="password" placeholder="enter your password">
                </div>
                <button class="primary-btn" id="btn-login" type="submit">login</button>
                <div class="error-message">
                    <?php
                        if ( isset($error) && !empty($error) ) {
                            echo $error;
                        }
                    ?>
                </div>
            </form>
            <p id="sign-up-text">don't have an account? <a id="sign-up-link" href="create-account.php">sign up</a></p>
        </div>

    </div>
    
</body>
</html>