<?php
include_once "core/auth/checklogin.php";
?>


<!DOCTYPE html>
<html>
<title>Dashboard || Angel System</title>
<?php include_once "includes/css.php"; ?>

<body>


    <div class="main-content">

        <div class="sidebar rnd4">
            <a class="active" href="dashboard.php">Dashboard</a>
            <a href="">Cars</a>
            <a href="">Rent</a>
            <a href="users.php">Users</a>
            <a href="logout.php">Logout</a>
        </div>

        <div class="content rnd8">

            <p>
                Welcome, <?php echo $name; ?>

            </p>
        </div>

    </div>

    <?php include_once "includes/js.php"; ?>
</body>

</html>