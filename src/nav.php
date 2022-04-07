<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<div class="nav-container">
    <div class="nav-title-container">
        <h1>chore<span>UP</span></h1>
    </div>

    <div class="nav-links">
        <?php if ( isset($_SESSION['logged_in']) && !empty($_SESSION['logged_in']) ) : ?>
            <a href="home.php">home</a>
            <a href="shop.php">shop</a>
            <a href="logout.php">logout</a>
        <?php else : ?>
            <a href="index.php">login/sign up</a>
        <?php endif; ?>
    </div>

</div>
