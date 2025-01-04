<?php

require_once('../model/database.php');

function adminLogin($username, $password)
{
  $conn = getConnection();
  $sql = "SELECT * FROM admins WHERE username='{$username}' and password='{$password}'";
  $result = mysqli_query($conn, $sql);
  $count = mysqli_num_rows($result);

  if ($count == 1) {
    return true;
  }
  return false;
}
function userLogin($username, $password)
{
  $conn = getConnection();
  $sql = "SELECT * FROM users WHERE username='{$username}' and password='{$password}'";
  $result = mysqli_query($conn, $sql);
  $count = mysqli_num_rows($result);

  if ($count == 1) {
    return true;
  }
  return false;
}

function getAdmin($username)
{
  $conn = getConnection();
  $sql = "SELECT * FROM admins WHERE username='{$username}'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) == 1) {
    return mysqli_fetch_assoc($result);
  }
  return false;
}

function getUser($username)
{
  $conn = getConnection();
  $sql = "SELECT * FROM users WHERE username='{$username}'";
  $result = mysqli_query($conn, $sql);

  if ($result && mysqli_num_rows($result) == 1) {
    return mysqli_fetch_assoc($result);
  }
  return false;
}

function getAllUser()
{
  $con = getConnection();
  $sql = "SELECT * FROM users";
  $result = mysqli_query($con, $sql);

  $users = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
  }
  return $users;
}

function addUser($name, $email, $username, $password, $age, $dob, $gender, $address)
{
  $conn = getConnection();
  $sql = "INSERT INTO users (name, email, username, password, age, dob, gender, address) 
          VALUES ('{$name}', '{$email}', '{$username}', '{$password}', {$age}, '{$dob}', '{$gender}', '{$address}')";
  if (mysqli_query($conn, $sql)) {
    return true;
  } else {
    error_log("MySQL Error: " . mysqli_error($conn));
    return false;
  }
}

function deleteUser($id)
{
    $conn = getConnection();
    $sql = "DELETE FROM users WHERE id='{$id}'";

    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        return false;
    }
}

function updateUser($id, $name, $email, $username, $password, $age, $dob, $gender, $address)
{
    $conn = getConnection();
    $sql = "UPDATE users SET name='{$name}',email='{$email}', username='{$username}', password='{$password}',age='{$age}', dob='{$dob}', gender='{$gender}', address='{$address}' WHERE id='{$id}'";

    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        return false;
    }
}

// Function to save vehicle registration data

function saveVehicleRegistration($permitType, $vehicleReg, $chassisNumber, $ownerName, $driverLicense, $applicationFormPath, $inspectionCertificatePath)

{

    $conn = getConnection();

    $sql = "INSERT INTO vehicle_registrations (permit_type, vehicle_reg, chassis_number, owner_name, driver_license, application_form, inspection_certificate) 

            VALUES (?, ?, ?, ?, ?, ?, ?)";
 
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, 'sssssss', $permitType, $vehicleReg, $chassisNumber, $ownerName, $driverLicense, $applicationFormPath, $inspectionCertificatePath);
 
    if (mysqli_stmt_execute($stmt)) {

        return true;

    } else {

        error_log("MySQL Error: " . mysqli_error($conn));

        return false;

    }

}

// Function to save tax token application data
function saveTaxTokenApplication($vehicleType, $regNum, $chassisNum, $name, $licenseNum, $permitFilePath, $inspectionFilePath)
{
    $conn = getConnection();
    $sql = "INSERT INTO tax_tokens (vehicle_type, reg_number, chassis_number, name, license_number, permit_file, inspection_file) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
 
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sssssss', $vehicleType, $regNum, $chassisNum, $name, $licenseNum, $permitFilePath, $inspectionFilePath);
 
    if (mysqli_stmt_execute($stmt)) {
        return true;
    } else {
        error_log("MySQL Error: " . mysqli_error($conn));
        return false;
    }
}
 
// Function to save payment details
function savePaymentDetails($paymentMethod, $cardNumber, $cvv, $expiryMonth, $expiryYear, $transactionID)
{
    $conn = getConnection();
    $sql = "INSERT INTO payments (payment_method, card_number, cvv, expiry_month, expiry_year, transaction_id) 
            VALUES (?, ?, ?, ?, ?, ?)";
 
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssss', $paymentMethod, $cardNumber, $cvv, $expiryMonth, $expiryYear, $transactionID);
 
    if (mysqli_stmt_execute($stmt)) {
        return true;
    } else {
        error_log("MySQL Error: " . mysqli_error($conn));
        return false;
    }
}

function getTotalUsers() {
  $conn = getConnection();
  $sql = "SELECT COUNT(*) AS total FROM users";
  $result = mysqli_query($conn, $sql);
  $data = mysqli_fetch_assoc($result);
  return $data['total'];
}