<?php
require "./config/config.php";

$owner_ID = $_POST['creatorID'];
$team_name = $_POST['teamName'];
$players_ids = $_POST['player_ids'];
if ( !isset($_POST['creatorID']) || empty($_POST['creatorID']) || !isset($_POST['teamName']) || empty($_POST['teamName']) || !isset($_POST['player_ids']) || empty($_POST['player_ids']) ) {
    echo "invalid inputs";
    exit();
}

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ( $mysqli->errno ) {
    echo $mysqli->error;
    exit();
}
$mysqli->set_charset('utf8');


// echo $searchTerm;
$teams_statement = $mysqli->prepare("INSERT INTO teams(name) VALUES(?)");
$teams_statement->bind_param("s", $_POST['teamName']);
$teams_executed = $teams_statement->execute();
if(!$teams_executed) {
    echo $mysqli->error;
    exit();
}

// GET TEAM INFO
// $teams_results = $teams_statement->get_result();
// $teams_row = $teams_results->fetch_assoc();
$team_sql = "SELECT * FROM teams WHERE name = '" . $_POST['teamName'] . "';";
$team_result = $mysqli->query($team_sql);
if (!$team_result) {
    echo $mysqli->error;
    exit();
}
$team_row = $team_result->fetch_assoc();
$team_id = $team_row['id'];

// Add team to Owner (user_has_teams)

$owner_statement = $mysqli->prepare("INSERT INTO user_has_teams(user_id, team_id) VALUES(?, ?)");
$owner_statement->bind_param("ii", $owner_ID, $team_id);
$owner_executed = $owner_statement->execute();
if (!$owner_executed) {
    echo $mysqli->error;
    exit();
}

// Add team to Team Players (user_has_teams)
foreach ($players_ids as $user_id) {
    $user_statement = $mysqli->prepare("INSERT INTO user_has_teams(user_id, team_id) VALUES(?, ?)");
    $user_statement->bind_param("ii", $user_id, $team_id);
    $user_executed = $user_statement->execute();
    if (!$user_executed) {
        echo $mysqli->error;
        exit();
    }
}

echo "success";

?>