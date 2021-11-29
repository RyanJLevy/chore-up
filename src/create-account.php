<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>choreUP | Create Account</title>
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="./styles/login.css">
</head>
<body>
    <?php include "nav.php"; ?>
    <div id="page-container">
        <div id="login-container">
            <form action="" method="">
                <h1>create account</h1>
                <div id="field-container">
                    <p>email</p>
                    <input type="text" class="form-input" id="email-input" name="email" placeholder="enter your email">
                    <p>username</p>
                    <input type="text" class="form-input" id="username-input" name="username" placeholder="enter your username">
                    <p>password</p>
                    <input type="password" class="form-input" id="password-input" name="password" placeholder="enter your password">
                </div>
                <button class="primary-btn" id="btn-login" type="submit">sign up</button>
            </form>
            <p id="sign-up-text">already have an account? <a id="sign-up-link" href="index.php">login</a></p>
        </div>

    </div>
</body>
</html>