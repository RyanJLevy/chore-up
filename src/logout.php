<?php
    session_start(); 
    
    session_unset();
    session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>choreUP | Login</title>
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="./styles/confirmation.css">

</head>
<body>
    <?php include "nav.php"; ?>
    <div id="page-container">
        <div id="confirmation-container">
            <h1>logout</h1>
            <div id="response-container">
                <p>you are now logged out</p>
            </div>
        </div>
    </div>
    
</body>
</html>