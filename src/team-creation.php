<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>choreUP | Team Creation</title>
    <script src="https://kit.fontawesome.com/d4a13a138b.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="./styles/create-team.css">
</head>
<body>
    <?php include "nav.php"; ?>
    <div id="page-container">
        <div id="create-team-container">
            <form action="" method="">
                <h1>create team</h1>
                <div id="field-container">
                    <p class="field-header">team name</p>
                    <input type="text" id="team-name-input" class="form-input" name="team-name" placeholder="enter team name">
                    <p class="field-header">team players</p>
                    <div id="added-user-container">

                    </div>
                    <p class="field-header header-add-players">add players</p>
                    <div id="user-search-container">
                        <input type="text" id="user-name-input" class="form-input" placeholder="enter user name">
                        <button id="user-search-btn" class="secondary-btn">+</button>
                    </div>

                </div>
                <button type="submit" id="create-team-btn" class="primary-btn create-btn">lets go!</button>
            </form>
        </div>

    </div>
    <script src="./scripts/create-team.js"></script>
</body>
</html>