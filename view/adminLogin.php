<?php
session_start();
 
// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    header('Location: adminDashboard.php');
    exit();
}
 
// Include necessary files
require_once('../model/authModel.php');
 
$error = '';
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
 
    // Validate credentials
    $authModel = new AuthModel();
    $admin = $authModel->authenticateAdmin($username, $password); // Ensure this function exists in authModel.php
 
    if ($admin) {
        // Set session variables
        $_SESSION['username'] = $admin['username'];
        $_SESSION['role'] = 'admin';
        header('Location: adminDashboard.php');
        exit();
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
 
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>
<link rel="stylesheet" href="../assets/styles.css">
</head>
 
<body>
<div class="login-container">
<h1>Admin Login</h1>
<?php if ($error): ?>
<p style="color: red;"><?= $error ?></p>
<?php endif; ?>
<form action="adminLogin.php" method="POST">
<label for="username">Username:</label>
<input type="text" id="username" name="username" required>
<br>
<label for="password">Password:</label>
<input type="password" id="password" name="password" required>
<br>
<button type="submit">Login</button>
</form>
</div>
</body>
 
</html>