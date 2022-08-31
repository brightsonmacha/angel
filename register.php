<?php
session_start();
include_once "core/db/connection.php";
include_once "core/utils/validator.php";
include_once "core/model/user_model.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new DbConnection();
    $dbConn =  $conn->getConnection();
    $validation = new Validator();
    $userModel = new UserModel();

    //validating input
    $name = $validation->sanitizeInput($_POST['name']);
    $email = $validation->sanitizeInput($_POST['email']);
    $password = $validation->sanitizeInput($_POST['password']);
    $password2 = $validation->sanitizeInput($_POST['password2']);

    $error = "";

    if (strlen($name) == 0 || strlen($email) == 0 || strlen($password) == 0 || strlen($password2) == 0) {
        $error = $error . 'All field required <br>';
    } else {

        if ($password != $password2) {
            $error = $error . 'Password dont match <br>';
        }

        if ($validation->validateEmail($email) == 0) {
            $error = $error . 'Provide valid email <br>';
        }

        //checking error
        if (strlen($error) > 0) {
            $errorH = "<b>Please fix error.</b> <br>" . $error;
        } else {
            if ($userModel->checkEmailExist($email)) {
                $errorH = "Email exist, try different.";
            } else {
                $passwordH =  md5($password);
                $regResult = $userModel->registerUser($name, $email, $passwordH);
                if ($regResult) {
                    $msg = "Successfuly Registration";
                    $email = $name = "";
                } else {
                    $errorH = "Fail to register, try againg.";
                }
            }
        }
    }
}

?>


<!DOCTYPE html>
<html>
<title>Register || Angel System</title>
<?php include_once "includes/css.php"; ?>

<body>
    <div class="main-content">
        <div class="login">

            <div class="signin-card">
                <h1>Register</h1>
                <p>Please fill in this form to create an account.</p>
            </div>

            <?php include_once 'includes/error_msg.php'; ?>


            <form method="POST" action="" class="form-group">

                <label for="email"><b>Fullname</b></label>
                <input type="text" placeholder="Enter fullname" value="<?php echo isset($name) ? $name : ''; ?>" name="name" required>

                <label for="email"><b>Email</b></label>
                <input type="text" placeholder="Enter Email" value="<?php echo isset($email) ? $email : ''; ?>" name="email" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" required>

                <label for="psw-repeat"><b>Repeat Password</b></label>
                <input type="password" placeholder="Repeat Password" name="password2" required>

                <button type="submit" class="btn btn-blue rnd8">Register</button>

            </form>

            <p>Already have an account? <a class="a-link" href="index.php">Login</a>.</p>


        </div>

    </div>

    <?php
    include_once "includes/js.php";
    ?>
</body>

</html>