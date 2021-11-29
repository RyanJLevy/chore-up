<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>choreUP | home</title>
    <script src="https://kit.fontawesome.com/d4a13a138b.js" crossorigin="anonymous"></script>
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
                    <p class="info-body">budgey</p>
                </div>
                <div class="info-row">
                    <p class="info-header">email</p>
                    <p class="info-body">budgey@gmail.com</p>
                </div>
                <div class="info-row">
                    <p class="info-header">points</p>
                    <p class="info-body">25</p>
                </div>
            </div>

            <button class="primary-btn" id="btn-edit-profile">edit profile <i class="fas fa-pen"></i></button>

        </div>

        <div id="teams-container">
            <p class="section-header">your teams</p>
            <div id="teams-selection-container">
                <!-- REPLACE WITH PHP DYNAMIC CREATION,  -->
                <button class="primary-btn teams-btn">🍽 supper house</button>
                <button class="primary-btn teams-btn">home 🏡</button>
            </div>
            <div class="btn-container">
                <button id="btn-add-team" class="secondary-btn add-team-btn">+ new team</button>
            </div>    
        </div>
    </div>
    
    <script src="./scripts/home.js"></script>
</body>
</html>