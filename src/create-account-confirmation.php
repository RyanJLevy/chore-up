<?php

require './config/config.php';

if ( !isset($_POST['email']) || empty($_POST['email'])
	|| !isset($_POST['username']) || empty($_POST['username'])
	|| !isset($_POST['password']) || empty($_POST['password']) ) {
	$error = "Please fill out all required fields.";
}
else {
	// Connect to DB
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}

	$statement_registered = $mysqli->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
	$statement_registered->bind_param("ss", $_POST['username'], $_POST['email']);
	$executed_registered = $statement_registered->execute();
	if (!$executed_registered) {
		echo $mysqli->error;
		exit();
	}

	$statement_registered->store_result();
	$numrows = $statement_registered->num_rows();

	$statement_registered->close();

	// email is taken
	if ( $numrows > 0 ) {
		$error = "Username or email has already been taken. Please choose another one.";
	}
	else {
		$password = hash("sha256", $_POST['password']);

		$statement = $mysqli->prepare("INSERT INTO users(username, email, password) VALUES(?, ?, ?)");
		$statement->bind_param("sss", $_POST['username'], $_POST['email'], $password);
		$executed = $statement->execute();
		if (!$executed) {
			echo $mysqli->error;
			exit();
		}
		$statement->close();
	}
	$mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>choreUP | Login</title>
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="./styles/confirmation.css">

</head>
<body>
    <?php include "nav.php"; ?>
    <div id="page-container">
        <div id="confirmation-container">
            <h1>user registration</h1>
            <div id="response-container">
                <?php if ( isset($error) && !empty($error) ) : ?>
					<div class="error-message"><?php echo $error; ?></div>
				<?php else : ?>
					<div class="success-message"><?php echo $_POST['username']; ?> was successfully registered.</div>
				<?php endif; ?>
            </div>
        </div>
    </div>
    
</body>
</html>