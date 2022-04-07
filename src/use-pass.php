<?php
require "./config/config.php";

if ( !isset($_GET['chore_id']) || empty($_GET['chore_id']) || !isset($_GET['user_id']) || empty($_GET['user_id']) ) {
    echo "invalid";
    exit();
}
else {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->errno) {
        echo $mysqli->error;
        exit();
    }

    $sql_passes = "SELECT passes FROM users WHERE id = " . $_GET['user_id'] . ";";
    $executed_passes = $mysqli->query($sql_passes);
    if (!$executed_passes) {
        echo $mysqli->error;
        exit();
    }
    $row_passes = $executed_passes->fetch_assoc();
    if ($row_passes['passes'] != 0) {

        $prepared = $mysqli->prepare("UPDATE chores SET is_complete = 1 WHERE id = ?");
        $prepared->bind_param("i", $_GET['chore_id']);
        $executed = $prepared->execute();
        if (!$executed) {
            echo $mysqli->error;
            exit();
        }

        $prepared_user = $mysqli->prepare("UPDATE users SET points = points + 1, passes = passes - 1 WHERE id = ?");
        $prepared_user->bind_param("i", $_GET['user_id']);
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
    else {
        echo "passes";
    }
}



?>