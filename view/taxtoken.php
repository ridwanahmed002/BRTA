<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply Page</title>
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $vehicleType = $_POST['vehicletype'];
        $regNum = $_POST['reg_num'];
        $chassisNum = $_POST['chassis_num'];
        $name = $_POST['name'];
        $licenseNum = $_POST['ln'];

        $permitFile = $_FILES['permit'];
        $inspectionFile = $_FILES['inspection'];

        // File validation
        $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        $maxFileSize = 5 * 1024 * 1024; // 5MB

        $errors = [];

        if (!in_array($permitFile['type'], $allowedTypes) || $permitFile['size'] > $maxFileSize) {
            $errors[] = "Invalid Permit Application file.";
        }
        if (!in_array($inspectionFile['type'], $allowedTypes) || $inspectionFile['size'] > $maxFileSize) {
            $errors[] = "Invalid Inspection Certificate file.";
        }

        if (empty($errors)) {
            // Save uploaded files (you can adjust the target directory)
            $targetDir = "uploads/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            move_uploaded_file($permitFile['tmp_name'], $targetDir . basename($permitFile['name']));
            move_uploaded_file($inspectionFile['tmp_name'], $targetDir . basename($inspectionFile['name']));

            // Save form data (simulation)
            echo "<p style='color: green;'>Application submitted successfully!</p>";
            echo "<p><strong>Details:</strong></p>";
            echo "<p>Vehicle Type: $vehicleType</p>";
            echo "<p>Registration Number: $regNum</p>";
            echo "<p>Chassis Number: $chassisNum</p>";
            echo "<p>Full Name: $name</p>";
            echo "<p>License Number: $licenseNum</p>";
        } else {
            foreach ($errors as $error) {
                echo "<p style='color: red;'>$error</p>";
            }
        }
    }
    ?>

    <form action="../controller/taxTokenHandler.php" method="POST" enctype="multipart/form-data">
        <fieldset style="width: 50%; margin: auto;">
            <h3 style="text-align: center;">Apply For Tax Token</h3>
            <table style="margin: auto; text-align: left;">
                <tr>
                    <th>Permit Type:</th>
                    <td>
                        <select name="vehicletype" required>
                            <option value="car">Car</option>
                            <option value="bike">Bike</option>
                            <option value="truck">Truck</option>
                            <option value="bus">Bus</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Registration Number:</th>
                    <td><input type="text" id="reg_num" name="reg_num" required></td>
                </tr>
                <tr>
                    <th>Chassis Number:</th>
                    <td><input type="text" id="chassis_num" name="chassis_num" required></td>
                </tr>
                <tr>
                    <th>Full Name:</th>
                    <td><input type="text" id="name" name="name" required></td>
                </tr>
                <tr>
                    <th>License Number:</th>
                    <td><input type="text" id="ln" name="ln" required></td>
                </tr>
                <tr>
                    <th>Permit Application Type:</th>
                    <td><input type="file" id="permit" name="permit" accept="image/*,application/pdf" required></td>
                </tr>
                <tr>
                    <th>Inspection Certificate:</th>
                    <td><input type="file" id="inspection" name="inspection" accept="image/*,application/pdf" required></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <button type="submit">Submit Application</button>
                    </td>
                </tr>
            </table>
        </fieldset>
    </form>
</body>
</html>
