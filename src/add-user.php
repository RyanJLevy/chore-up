<?php
require "./config/config.php";
session_start();

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ( $mysqli->errno ) {
    echo $mysqli->error;
    exit();
}
$mysqli->set_charset('utf8');


// Handle search for self
if ($_GET['username'] == $_SESSION['username']) {
    echo "self";
    exit();
}

$searchTerm = "%" . $_GET["username"] . "%";
// echo $searchTerm;
$statement = $mysqli->prepare("SELECT id, username FROM users WHERE username LIKE ?");
$statement->bind_param("s", $searchTerm);
$executed = $statement->execute();
if(!$executed) {
    echo $mysqli->error;
    exit();
}

// How prepared statement gets results
$results = $statement->get_result();
$mysqli->close();

// Now can do $results->fetch_assoc() to get the first result

// Create a separate array to store our results
$results_array = [];

// Run through all the results from the database and push each result into our newly created array
while($row = $results->fetch_assoc()) {
    array_push($results_array, $row);
}

// Send results as json formatted string
echo json_encode($results_array);
?>