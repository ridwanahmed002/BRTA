<?php
 
require_once('../model/authModel.php');
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $paymentMethod = $_POST['payment_method'] ?? '';
    $cardNumber = $_POST['card_number'] ?? '';
    $cvv = $_POST['cvv'] ?? '';
    $expiryMonth = $_POST['expiry_month'] ?? '';
    $expiryYear = $_POST['expiry_year'] ?? '';
 
    // Validation
    $errors = [];
 
    if (!$paymentMethod) {
        $errors[] = "Payment method is required.";
    }
    if (!preg_match('/^\\d{16}$/', $cardNumber)) {
        $errors[] = "Card number must be 16 digits.";
    }
    if (!preg_match('/^\\d{3}$/', $cvv)) {
        $errors[] = "CVV must be 3 digits.";
    }
    if (!$expiryMonth || !$expiryYear) {
        $errors[] = "Expiry date is required.";
    }
 
    if (empty($errors)) {
        // Generate transaction ID
        $transactionID = uniqid("PAY-");
 
        // Save payment details
        $success = savePaymentDetails($paymentMethod, $cardNumber, $cvv, $expiryMonth, $expiryYear, $transactionID);
 
        if ($success) {
            echo "<div style='color: green;'>Payment Successful!<br>Transaction ID: $transactionID</div>";
        } else {
            echo "<div style='color: red;'>Failed to process payment. Please try again later.</div>";
        }
    } else {
        foreach ($errors as $error) {
            echo "<div style='color: red;'>$error</div>";
        }
    }
}
 
?>