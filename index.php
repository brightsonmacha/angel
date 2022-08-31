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
    $email = $validation->sanitizeInput($_POST['email']);
    $password = $validation->sanitizeInput($_POST['password']);

    $error = "";

    if (strlen($email) == 0 || strlen($password) == 0) {
        $error = 'Email or password cant be empty';
    }

    //checking error
    if (strlen($error) > 0) {
        $errorH = "<b>Please fix error.</b> <br>" . $error;
    } else {
        $numRow = $userModel->getUserByEmailCount($email);

        if ($numRow == 1) {
            $user = $userModel->getUserByEmail($email);
            $passwordDb = $user['password'];

            if($passwordDb == md5($password)){
                $_SESSION["email"] = $user['email'];
                $_SESSION["name"] = $user['fullName'];
                $_SESSION["login"] = "true";
                
                header("Location: dashboard.php");
            }else{
                $errorH = "Invalid credentials";
            }
        } else {
            $errorH = "Invalid credentials";
        }
    }
}

?>

<!DOCTYPE html>
<html>
<title>Login || Angel System</title>
<?php include_once "includes/css.php"; ?>

<body>
    <div class="main-content">

        <div class="login">

            <div class="signin-card">
                <h1>Login</h1>
                <p>Provide credentials</p>
            </div>

            
            <?php include_once 'includes/error_msg.php'; ?>


            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form-group">

                <label for="email"><b>Email</b></label>
                <input type="text" placeholder="Enter Email" name="email" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" required>


                <button type="submit" class="btn btn-blue rnd8">Login</button>

            </form>

            <p>Don't have an account? <a class="a-link" href="register.php">Register</a>.</p>


        </div>

    </div>

    <?php include_once "includes/js.php"; ?>
</body>

</html>