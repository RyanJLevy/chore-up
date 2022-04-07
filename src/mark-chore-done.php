<?php
require "./config/config.php";

if ( !isset($_POST['chore_id']) || empty($_POST['chore_id']) || !isset($_POST['user_id']) || empty($_POST['user_id']) ) {
    echo "invalid";
    exit();
}
else {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->errno) {
        echo $mysqli->error;
        exit();
    }

    $prepared = $mysqli->prepare("UPDATE chores SET is_complete = 1 WHERE id = ?");
    $prepared->bind_param("i", $_POST['chore_id']);
    $executed = $prepared->execute();
    if (!$executed) {
        echo $mysqli->error;
        exit();
    }

    $prepared_user = $mysqli->prepare("UPDATE users SET points = points + 1 WHERE id = ?");
    $prepared_user->bind_param("i", $_POST['user_id']);
    $executed_user = $prepared_user->execute();
    if (!$executed_user) {
        echo $mysqli->error;
        exit();
    }

    $prepared_user->close();
    $prepared->close();
    $mysqli->close();

    echo "success";
}



?>