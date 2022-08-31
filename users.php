<?php
include_once "core/auth/checklogin.php";
?>


<!DOCTYPE html>
<html>
<title>Users || Angel System</title>
<?php include_once "includes/css.php"; ?>

<body>
    <div class="main-content">

        <div class="sidebar rnd4">
            <a href="dashboard.php">Dashboard</a>
            <a href="">Cars</a>
            <a href="">Rent</a>
            <a class="active" href="users.php">Users</a>
            <a href="logout.php">Logout</a>
        </div>

        <div class="content rnd8">
            <h2>Responsive Sidebar Example</h2>
            <p>This example use media queries to transform the sidebar to a top navigation bar when the screen size is 700px or less.</p>
            <p>We have also added a media query for screens that are 400px or less, which will vertically stack and center the navigation links.</p>
            <h3>Resize the browser window to see the effect.</h3>
        </div>

    </div>

    <?php include_once "includes/js.php"; ?>
</body>

</html>