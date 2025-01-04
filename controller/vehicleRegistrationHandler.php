<?php
 
require_once('../model/authModel.php');
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Retrieve form data

    $permitType = $_POST['permit_type'] ?? '';

    $vehicleReg = $_POST['vehicle_reg'] ?? '';

    $chassisNumber = $_POST['chassis_number'] ?? '';

    $ownerName = $_POST['owner_name'] ?? '';

    $driverLicense = $_POST['driver_license'] ?? '';
 
    // Handle file uploads

    $applicationForm = $_FILES['application_form'] ?? null;

    $inspectionCertificate = $_FILES['inspection_certificate'] ?? null;
 
    // Validation

    $errors = [];

    if (!$permitType) $errors[] = "Permit type is required.";

    if (!$vehicleReg) $errors[] = "Vehicle registration number is required.";

    if (!$chassisNumber) $errors[] = "Chassis number is required.";

    if (!$ownerName) $errors[] = "Owner name is required.";

    if (!$driverLicense) $errors[] = "Driver's license number is required.";
 
    // File upload paths

    $uploadDir = '../uploads/';

    $applicationFormPath = $uploadDir . basename($applicationForm['name']);

    $inspectionCertificatePath = $uploadDir . basename($inspectionCertificate['name']);
 
    // Check file size and upload

    if ($applicationForm && $applicationForm['size'] > 5 * 1024 * 1024) {

        $errors[] = "Application form file size must not exceed 5 MB.";

    } else {

        move_uploaded_file($applicationForm['tmp_name'], $applicationFormPath);

    }
 
    if ($inspectionCertificate && $inspectionCertificate['size'] > 5 * 1024 * 1024) {

        $errors[] = "Inspection certificate file size must not exceed 5 MB.";

    } else {

        move_uploaded_file($inspectionCertificate['tmp_name'], $inspectionCertificatePath);

    }
 
    if (empty($errors)) {

        // Save data

        $success = saveVehicleRegistration(

            $permitType,

            $vehicleReg,

            $chassisNumber,

            $ownerName,

            $driverLicense,

            $applicationFormPath,

            $inspectionCertificatePath

        );
 
        if ($success) {

            echo "<div style='color: green;'>Vehicle registration successful!</div>";

        } else {

            echo "<div style='color: red;'>Failed to register vehicle. Please try again later.</div>";

        }

    } else {

        echo "<div style='color: red;'><strong>Errors:</strong><br>" . implode('<br>', $errors) . "</div>";

    }

}

?>

 