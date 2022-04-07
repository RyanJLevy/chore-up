<?php
session_start();
require "./config/config.php";
if (!isset($_GET['team_id']) || empty($_GET['team_id'])) {
    header("Location: ./home.php");
}
else {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->connect_errno) {
        echo $mysqli->error;
        exit();
    }

    // GET TEAM INFO
    $team_id = $_GET['team_id'];
    $sql_team = "SELECT * FROM teams WHERE id = " . $team_id . ";";
    $result_team = $mysqli->query($sql_team);
    if (!$result_team) {
        echo $mysqli->error;
        exit();
    }
    $row_team = $result_team->fetch_assoc();
    

    // GET ALL USERS IN TEAM
    $sql_all_users = "SELECT users.id, users.username FROM user_has_teams
    JOIN users
    ON user_has_teams.user_id = users.id
    WHERE user_has_teams.team_id = " . $team_id . ";";

    $result_all_users = $mysqli->query($sql_all_users);
    if (!$result_all_users) {
        echo $mysqli->error;
        exit();
    }

    // GET NUMBER OF USERS
    $sql_num_users = "SELECT COUNT(*) as num_users
    FROM user_has_teams
    WHERE team_id = " . $_GET['team_id'] . ";";

    $result_num_users = $mysqli->query($sql_num_users);
    if (!$result_num_users) {
        echo $mysqli->error;
        exit();
    }
    $row_num_users = $result_num_users->fetch_assoc();

    // GET NUM COMPLETED CHORES
    $sql_num_chores = "SELECT COUNT(*) as num_complete 
    FROM chores
    WHERE is_complete = 1 AND team_id = " . $_GET['team_id'] . ";";
    $result_num_chores = $mysqli->query($sql_num_chores);
    if (!$result_num_chores) {
        echo $mysqli->error;
        exit();
    }
    $row_num_chores = $result_num_chores->fetch_assoc();   

    $mysqli->close();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>choreUP | team info</title>
    <script src="https://kit.fontawesome.com/d4a13a138b.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="./styles/team-info.css">

</head>
<body>
    <?php include "nav.php"; ?>
    <div id="page-container">
        <div class="content-container">
            <div data-team-id="<?php echo $_GET['team_id']; ?>" id="team-info-container">
                <div class="information-container team-info">
                    <h1 id="information-chore-title"><?php echo $row_team['name']; ?> <span id="info-title-divide">|</span></h1>
                    <div id="team-info-more">
                        <button id="btn-favorite"><i class="far fa-star"></i></button>
                        <p class="team-info-header">players - <span class="team-info-stat"><?php echo $row_num_users['num_users']; ?></span></p>
                        <p class="team-info-header">completed - <span class="team-info-stat"><?php echo $row_num_chores['num_complete']; ?></span></p>
                    </div>
                    <hr id="mobile-info-divide"/>
                    <button id="btn-team-info-view" class="view-more-btn"><i class="fas fa-ellipsis-h"></i></button>
                </div>
            </div>

            <div class="information-container chore-container complete-container">
                <h1>completed</h1>
                <hr/>
                <div id="completed-card-container" class="chore-card-container">
                    
                </div>
            </div>

        </div>

        <div class="content-container">
            <div class="information-container chore-container todo-container">
                <h1>todo</h1>
                <hr/>
                <div id="todo-card-container" class="chore-card-container">
                    
                </div>
                <button id="add-chore-btn" class="secondary-btn">+ add chore</button>
            </div>
        </div>

        <div id="popup-overlay">

        </div>

        <!-- ADD CHORE POPUP -->

        <div id="add-chore-popup">
            <div id="add-chore-container">
                <h1>add chore</h1>
                <p class="input-header">chore name</p>
                <input class="input-field" type="text" id="chore-name">
                <p class="input-header">assigned player</p>
                <select id="chore-user" class="input-select" value="-1">
                    <option selected disabled>-- select player --</option>
                    <?php while ($row = $result_all_users->fetch_assoc()) : ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['username']; ?></option>
                    <?php endwhile; ?>
                </select>
                <button id="create-chore-btn" class="secondary-btn">+ create</button>
            </div>
            <button class="btn-exit" onclick="handlePopupExit('add-chore-popup')">X</button>
        </div>

        <!-- CHORE INFO POPUP -->
        
        <div id="chore-info-popup">
            <div id="chore-info-container">
                

            </div>
            <button class="btn-exit" onclick="handlePopupExit('chore-info-popup')">X</button>
        </div>

    </div>
    <script src="./scripts/team-info.js"></script>
</body>
</html>