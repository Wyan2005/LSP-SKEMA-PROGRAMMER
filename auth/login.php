<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/PROJECT_SERTIFIKASI/config/database.php';

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query(
        $conn,
        "SELECT * FROM admin WHERE username='$username' AND password='$password'"
    );

    if (mysqli_num_rows($query) === 1) {
        $_SESSION['login'] = true;
        $_SESSION['username'] = $username;
        header("Location: ../dashboard.php");
        exit;
    }

    header("Location: ../index.php");
    exit;
}
