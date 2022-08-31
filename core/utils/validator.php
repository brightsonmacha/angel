<?php
class Validator{
    public function validateEmail($data)
    {
        $data = filter_var($data, FILTER_SANITIZE_EMAIL);
        if (filter_var($data, FILTER_VALIDATE_EMAIL)) {
            return 1;
        } else {
            return 0;
        }
    }

    public function clearData($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = filter_var($data, FILTER_SANITIZE_STRING);

        return $data;
    }

    public function sanitizeInput($data)
    {
        global $dbConn;
        return mysqli_real_escape_string($dbConn, $this->clearData($data));
    }
}
