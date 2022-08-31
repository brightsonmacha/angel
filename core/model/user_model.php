<?php

include_once "./core/db/connection.php";

class UserModel
{


    public function checkEmailExist($email){
        global $dbConn;
        $sql = "SELECT * FROM users WHERE email = '$email' ";
        $result = mysqli_query($dbConn, $sql);

        $numRow = mysqli_num_rows($result);
        if ($numRow >= 1) {
            return true;
        } else {
            return false;
        } 
    }


    public function getUserByEmailCount($email)
    {
        global $dbConn;
        $sql = "SELECT * FROM users WHERE email = '$email' ";
        $result = mysqli_query($dbConn, $sql);
       
        $numRow = mysqli_num_rows($result);
        return $numRow;
    }

    public function getUserByEmail($email)
    {
        global $dbConn;
        $sql = "SELECT * FROM users WHERE email = '$email' ";
        $result = mysqli_query($dbConn, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function registerUser($name, $email, $password){
        global $dbConn;
        $sql = " INSERT INTO `users`( `fullName`, `email`, `password`) VALUES ('$name','$email','$password') ";
        return mysqli_query($dbConn, $sql);
    }
}
