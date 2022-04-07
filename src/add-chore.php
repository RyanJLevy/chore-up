<?php
require "./config/config.php";

if ( !isset($_POST['chore_title']) || empty($_POST['chore_title']) || !isset($_POST['user_id']) || empty($_POST['user_id']) || !isset($_POST['team_id']) || empty($_POST['team_id']) ) {
    echo "empty";
    exit();
}
else {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->errno) {
        echo $mysqli->error;
        exit();
    }

    $prepared = $mysqli->prepare("INSERT INTO chores(chore_name, team_id, user_id) VALUES(?, ?, ?)");
    $prepared->bind_param("sii", $_POST['chore_title'], $_POST['team_id'], $_POST['user_id']);
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