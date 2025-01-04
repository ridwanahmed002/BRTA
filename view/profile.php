<?php
session_start();

if (!isset($_COOKIE['status']) && !isset($_SESSION['username'])) {
    header('location: login.php');
    exit();
}

$username = $_SESSION['username'];

require_once('../model/authModel.php');

$user = getUser($username);

if ($user === false) {
    echo "Error: User data not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
<nav class="navbar">
        <div class="container">
            <ul class="nav-links">
                <li><a href="../view/home.php" id="logo">BRTA</a></li>
                <li><a href="../view/home.php">Home</a></li>
                <li><a href="../view/userDashboard.php" id="btnReg">Dashboard</a></li>
            </ul>
        </div>
    </nav>
    <div class="profile-container">
        <div class="profile-card">
            <h1>Profile Information</h1>
            <table>
                <tr>
                    <th>Full Name</th>
                    <td><?= htmlspecialchars($user['name']); ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?= htmlspecialchars($user['email']); ?></td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td><?= htmlspecialchars($user['username']); ?></td>
                </tr>
                <tr>
                    <th>Age</th>
                    <td><?= htmlspecialchars($user['age']); ?></td>
                </tr>
                <tr>
                    <th>Date of Birth</th>
                    <td><?= htmlspecialchars($user['dob']); ?></td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td><?= htmlspecialchars($user['gender']); ?></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td><?= htmlspecialchars($user['address']); ?></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>