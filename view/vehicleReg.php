<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Registration Form - BRTA Service Portal</title>
</head>
<body>
    <h1>Vehicle Registration Form</h1>

    <form method="POST" action="../controller/vehicleRegistrationHandler.php" enctype="multipart/form-data">
        <!-- Select Permit Type -->
        <div>
            <label for="permit-type">Permit Type:</label>
            <select name="permit_type" id="permit-type" required>
                <option value="">Select Permit Type</option>
                <option value="Bus">Bus</option>
                <option value="Truck">Truck</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <!-- Vehicle and Owner Details -->
        <div>
            <label for="vehicle-reg">Vehicle Registration Number:</label>
            <input type="text" name="vehicle_reg" id="vehicle-reg" required pattern="[A-Za-z0-9-]{1,20}" title="Valid registration number required">
        </div>

        <div>
            <label for="chassis-number">Chassis Number:</label>
            <input type="text" name="chassis_number" id="chassis-number" required pattern="[A-Za-z0-9]{1,20}" title="Valid alphanumeric chassis number required">
        </div>

        <div>
            <label for="owner-name">Owner Name:</label>
            <input type="text" name="owner_name" id="owner-name" required>
        </div>

        <div>
            <label for="driver-license">Driver's License Number:</label>
            <input type="text" name="driver_license" id="driver-license" required pattern="[A-Za-z0-9]{1,15}" title="Valid driver's license number required">
        </div>

        <!-- Upload Necessary Documents -->
        <div>
            <label for="application-form">Permit Application Form (PDF, JPEG, PNG):</label>
            <input type="file" name="application_form" id="application-form" accept=".pdf,.jpeg,.jpg,.png" required>
        </div>

        <div>
            <label for="inspection-certificate">Vehicle Inspection Certificate (PDF, JPEG, PNG):</label>
            <input type="file" name="inspection_certificate" id="inspection-certificate" accept=".pdf,.jpeg,.jpg,.png" required>
        </div>

        <!-- Submit Application -->
        <div>
            <button type="submit" name="submit">Submit Application</button>
        </div>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $permitType = $_POST['permit_type'] ?? '';
        $vehicleReg = $_POST['vehicle_reg'] ?? '';
        $chassisNumber = $_POST['chassis_number'] ?? '';
        $ownerName = $_POST['owner_name'] ?? '';
        $driverLicense = $_POST['driver_license'] ?? '';

        // File uploads
        $applicationForm = $_FILES['application_form'] ?? null;
        $inspectionCertificate = $_FILES['inspection_certificate'] ?? null;

        // Validation checks
        $errors = [];

        if (!$permitType) {
            $errors[] = "Permit type is required.";
        }
        if (!$vehicleReg) {
            $errors[] = "Vehicle registration number is required.";
        }
        if (!$chassisNumber) {
            $errors[] = "Chassis number is required.";
        }
        if (!$ownerName) {
            $errors[] = "Owner name is required.";
        }
        if (!$driverLicense) {
            $errors[] = "Driver's license number is required.";
        }

        if ($applicationForm && $applicationForm['size'] > 5 * 1024 * 1024) {
            $errors[] = "Application form file size must not exceed 5 MB.";
        }
        if ($inspectionCertificate && $inspectionCertificate['size'] > 5 * 1024 * 1024) {
            $errors[] = "Inspection certificate file size must not exceed 5 MB.";
        }

        if (empty($errors)) {
            // Simulate saving data (replace with actual database code)
            $referenceNumber = uniqid("BRTA-");

            echo "<div style='color: green;'>Your application has been successfully submitted!<br>Reference Number: $referenceNumber</div>";

            // Redirect to application status page (replace with actual URL)
            echo "<script>setTimeout(() => { window.location.href = 'application_status.php'; }, 5000);</script>";
        } else {
            echo "<div style='color: red;'><strong>Errors:</strong><br>" . implode('<br>', $errors) . "</div>";
        }
        
    }
    ?>
</body>
</html>
