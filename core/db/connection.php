<?php
define('DB_NAME', 'angel');
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

class DbConnection
{

    function getConnection()
    {
        $db_connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (!$db_connection) {
            die("Database Connection Error: " . mysqli_connect_error());
        }
        return $db_connection;
    }
}