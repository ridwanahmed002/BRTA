<?php
 
require_once('../model/authModel.php');
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $vehicleType = $_POST['vehicletype'] ?? '';
    $regNum = $_POST['reg_num'] ?? '';
    $chassisNum = $_POST['chassis_num'] ?? '';
    $name = $_POST['name'] ?? '';
    $licenseNum = $_POST['ln'] ?? '';
 
    // Handle file uploads
    $permitFile = $_FILES['permit'] ?? null;
    $inspectionFile = $_FILES['inspection'] ?? null;
 
    // Validation
    $errors = [];
    $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
    $maxFileSize = 5 * 1024 * 1024; // 5MB
 
    if (!in_array($permitFile['type'], $allowedTypes) || $permitFile['size'] > $maxFileSize) {
        $errors[] = "Invalid Permit Application file.";
    }
    if (!in_array($inspectionFile['type'], $allowedTypes) || $inspectionFile['size'] > $maxFileSize) {
        $errors[] = "Invalid Inspection Certificate file.";
    }
 
    // File upload paths
    $uploadDir = '../uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
 
    $permitFilePath = $uploadDir . basename($permitFile['name']);
    $inspectionFilePath = $uploadDir . basename($inspectionFile['name']);
 
    if (empty($errors)) {
        move_uploaded_file($permitFile['tmp_name'], $permitFilePath);
        move_uploaded_file($inspectionFile['tmp_name'], $inspectionFilePath);
 
        // Save data
        $success = saveTaxTokenApplication(
            $vehicleType,
            $regNum,
            $chassisNum,
            $name,
            $licenseNum,
            $permitFilePath,
            $inspectionFilePath
        );
 
        if ($success) {
            echo "<div style='color: green;'>Tax token application submitted successfully!</div>";
        } else {
            echo "<div style='color: red;'>Failed to submit tax token application. Please try again later.</div>";
        }
    } else {
        foreach ($errors as $error) {
            echo "<div style='color: red;'>$error</div>";
        }
    }
}
 
?>