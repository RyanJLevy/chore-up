<?php
session_start();
require "./config/config.php";

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_errno) {
    echo $mysqli->error;
    exit();
}
$mysqli->set_charset('utf8');
$sql_user = "SELECT * FROM users WHERE username ='" . $_SESSION['username'] . "';";
$result_user = $mysqli->query($sql_user);
if (!$result_user) {
    echo $mysqli->error;
    exit();
}

$row_user = $result_user->fetch_assoc();
// var_dump($row_user);

// View teams
$sql_teams = "SELECT * 
FROM user_has_teams
JOIN teams
    ON user_has_teams.team_id = teams.id
WHERE user_id =" . $row_user['id'] . ";";
// echo $sql_teams;
$result_teams = $mysqli->query($sql_teams);
if (!$result_teams) {
    echo $mysqli->error;
    exit();
}
// var_dump($result_teams->fetch_assoc());


$mysqli->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>choreUP | home</title>
    <script src="https://kit.fontawesome.com/d4a13a138b.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="./styles/home.css">
</head>
<body>
    <?php include "nav.php"; ?>
    <div id="page-container">
        <div id="profile-container">
            <div class="profile-head">
                <p class="section-header">your profile</p>
                <i id="user-profile-avatar" class="fas fa-user-circle"></i>
            </div>

            <div id="section-split"></div>

            <div id="user-info-container">
                <div class="info-row">
                    <p class="info-header">username</p>
                    <p class="info-body"><?php echo $row_user['username']; ?></p>
                </div>
                <div class="info-row">
                    <p class="info-header">email</p>
                    <p class="info-body"><?php echo $row_user['email']; ?></p>
                </div>
                <div class="info-row">
                    <p class="info-header">points</p>
                    <p class="info-body"><?php echo $row_user['points']; ?></p>
                </div>
                <div class="info-row">
                    <p class="info-header">passes</p>
                    <p class="info-body"><?php echo $row_user['passes']; ?></p>
                </div>
            </div>

            <!-- <button class="primary-btn" id="btn-edit-profile">edit profile <i class="fas fa-pen"></i></button> -->

        </div>

        <div id="teams-container">
            <p class="section-header">your teams</p>
            <div id="teams-selection-container">
                <!-- REPLACE WITH PHP DYNAMIC CREATION,  -->
                <?php while ( $row = $result_teams->fetch_assoc() ) : ?>
                    <button data-team-id="<?php echo $row['id']; ?>" class="primary-btn teams-btn" onclick="handleTeamBtnClick(event)"><?php echo $row['name']; ?></button>
                <?php endwhile; ?>
            </div>
            <div class="btn-container">
                <a id="btn-add-team" class="secondary-btn add-team-btn" href="team-creation.php?user_id=<?php echo $row_user['id']; ?>">+ new team</a>
            </div>    
        </div>
    </div>
    
    <script src="./scripts/home.js"></script>
</body>
</html>