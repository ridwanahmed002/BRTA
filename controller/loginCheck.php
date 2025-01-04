<?php 
session_start();
require_once('../model/authModel.php');

if(isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        echo "Username and Password cannot be empty!";
    } else {
        // Check for user in admin table
        $admin = getAdmin($username, $password);
        // Check for user in users table
        $user = getUser($username, $password);

        if ($admin) {
            $_SESSION['username'] = $username;
            setcookie('status', 'true', time() + 10000, '/');
            header('location: ../view/adminDashboard.php');
            exit();
        } elseif ($user) {
            $_SESSION['username'] = $username;
            setcookie('status', 'true', time() + 10000, '/');
            header('location: ../view/userDashboard.php');
            exit();
        } else {
            echo "Invalid username or password!";
            header('location: ../view/login.php');
            exit();
        }
    }
} else {
    header('location: ../view/login.php');
    exit();
}
?>