<?php
session_start();
session_unset();
session_destroy();
setcookie('status', '', time() - 3600, '/'); // Expire the cookie
header('location: ../view/login.php');
exit();
?>