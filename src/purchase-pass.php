<?php
require "./config/config.php";

if ( !isset($_GET['user_id']) || empty($_GET['user_id']) ) {
    echo "invalid";
    exit();
}
else {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->errno) {
        echo $mysqli->error;
        exit();
    }

    $sql_passes = "SELECT points FROM users WHERE id = " . $_GET['user_id'] . ";";
    $executed_passes = $mysqli->query($sql_passes);
    if (!$executed_passes) {
        echo $mysqli->error;
        exit();
    }
    $row_passes = $executed_passes->fetch_assoc();
    if ($row_passes['points'] >= 5) {

        $prepared_user = $mysqli->prepare("UPDATE users SET points = points - 5, passes = passes + 1 WHERE id = ?");
        $prepared_user->bind_param("i", $_GET['user_id']);
        $executed_user = $prepared_user->execute();
        if (!$executed_user) {
            echo $mysqli->error;
            exit();
        }

        $prepared_user->close();
        $mysqli->close();

        echo "success";
    }
    else {
        echo "points";
    }
}



?>