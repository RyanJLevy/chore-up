<?php
session_start();
require "./config/config.php";

if (!isset($_SESSION)) {
    header("Location: ./index.php");
}
else {
    // GET USER PASSES AND POINTS
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->errno) {
        echo $mysqli->error;
        exit();
    }

    $sql = "SELECT points, passes FROM users WHERE username = '" . $_SESSION['username'] . "';";
    $result = $mysqli->query($sql);
    if (!$result) {
        echo $mysqli->error;
        exit();        
    }
    $row = $result->fetch_assoc();
    $mysqli->close();

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>choreUP | shop</title>
    <script src="https://kit.fontawesome.com/d4a13a138b.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="./styles/shop.css">

</head>
<body>
    <?php include "nav.php"; ?>
    <div id="page-container">
        <div id="shop-container">
            <h1>passes shop</h1>
            <p id="shop-description">trade in 5 points for 1 pass!</p>
            <p><i class="fas fa-ticket-alt"></i> you have <span><?php echo $row['passes']; ?></span> passes</p>
            <p><i class="fas fa-user"></i> you have <span><?php echo $row['points']; ?></span> points</p>
            <button class="primary-btn" id="buy-pass-btn">buy pass</button>
        </div>

    </div>
    <script src="./scripts/shop.js"></script>
</body>
</html>