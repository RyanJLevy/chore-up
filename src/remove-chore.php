<?php
require "./config/config.php";

if ( !isset($_POST['chore_id']) ) {
    echo "invalid";
    exit();
}
else {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->errno) {
        echo $mysqli->error;
        exit();
    }

    $prepared = $mysqli->prepare("DELETE FROM chores WHERE id = ?");
    $prepared->bind_param("i", $_POST['chore_id']);
    $executed = $prepared->execute();
    if (!$executed) {
        echo $mysqli->error;
        exit();
    }

    $prepared->close();
    $mysqli->close();

    echo "success";
}



?>