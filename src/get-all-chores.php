<?php
require "./config/config.php";

if ( !isset($_GET['team_id']) || empty($_GET['team_id'])) {
    echo "invalid";
    exit();
}
else {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->errno) {
        echo $mysqli->error;
        exit();
    }

    $sql = "SELECT * FROM chores WHERE team_id =  " . $_GET['team_id'] . ";";
    $executed = $mysqli->query($sql);
    if (!$executed) {
        echo $mysqli->error;
        exit();
    }

    $mysqli->close();

    $results_array = [];

	// Run through all the results from the database and push each result into our newly created array
	while($row = $executed->fetch_assoc()) {
		array_push($results_array, $row);
	}

    echo json_encode($results_array);
}



?>