<?php
namespace core\Model;

include 'base_model.php';

class UserModel extends BaseModel
{

    public function checkEmailExist($email)
    {
        $sql = "SELECT * FROM users WHERE email = '$email' ";
        $result = mysqli_query($this->dbConn, $sql);

        $numRow = mysqli_num_rows($result);
        if ($numRow >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserByEmailCount($email)
    {
        $sql = "SELECT * FROM users WHERE email = '$email' ";
        $result = mysqli_query($this->dbConn, $sql);

        $numRow = mysqli_num_rows($result);
        return $numRow;
    }

    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = '$email' ";
        $result = mysqli_query($this->dbConn, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function registerUser($name, $email, $password)
    {
        $sql = " INSERT INTO `users`( `fullName`, `email`, `password`) VALUES ('$name','$email','$password') ";
        return mysqli_query($this->dbConn, $sql);
    }
}
