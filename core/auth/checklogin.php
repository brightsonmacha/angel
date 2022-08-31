<?php
session_start();
if (!isset($_SESSION['login']) && !isset($_SESSION['email']) && !isset($_SESSION['login'])) {
    header("Location: index.php");
}

$name = $_SESSION['name'];
$login = $_SESSION['login'];
$email = $_SESSION['email'];