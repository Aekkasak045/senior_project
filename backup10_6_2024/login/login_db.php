<?php
session_start();
$errors = array();
include('con_db.php');
include('errors.php');

if (isset($_POST['login_btn'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (count($errors) == 0) {
        $query = "SELECT * FROM users WHERE username = '$username' AND password ='$password' ";
        $result = mysqli_query($conn, $query);
        $row = $result->fetch_assoc();
        if (mysqli_num_rows($result) == 1) {
            if ($row['role'] == 'admin') {
                $_SESSION['user_role'] = $row['role'];
                $_SESSION["username"] = $username;
                $_SESSION["success"] = "You are now logged in";
                header('location: ../Manage1/summary/summary.php');
            } else {
                array_push($errors, "You don't have permission to access.");
                $_SESSION['error']="You don't have permission to access.";
                header('location: login.php');
            }
        }else {
            array_push($errors, "You don't have permission to access.");
            $_SESSION['error']="You don't have permission to access.";
            header('location: login.php');
        }
    }
}
