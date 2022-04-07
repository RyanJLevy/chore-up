<?php 
require "./config/config.php";

if ( !isset($_GET['team_id']) || empty($_GET['team_id']) ) {
    echo "invalid data";
    exit();
}

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_errno) {
    echo $mysqli->error;
    exit();
}

$sql_all_users = "SELECT users.id, users.username FROM user_has_teams
JOIN users
ON user_has_teams.user_id = users.id
WHERE user_has_teams.team_id = " . $_GET['team_id'] . ";";

$result_all_users = $mysqli->query($sql_all_users);
if (!$result_all_users) {
    echo $mysqli->error;
    exit();
}

$mysqli->close();

$results_array = [];

// Run through all the results from the database and push each result into our newly created array
while($row = $result_all_users->fetch_assoc()) {
    array_push($results_array, $row);
}

echo json_encode($results_array);


?>