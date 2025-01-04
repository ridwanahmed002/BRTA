<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form - BRTA Service Portal</title>
</head>
<body>
    <h1>Payment Form</h1>

    <form method="POST" action="../controller/paymentHandler.php">
        <!-- Select Payment Method -->
        <div>
            <label for="payment-method">Payment Method:</label>
            <select name="payment_method" id="payment-method" required>
                <option value="">Select Payment Method</option>
                <option value="Credit/Debit Card">Credit/Debit Card</option>
                <option value="Online Banking">Online Banking</option>
                <option value="Mobile Payment">Mobile Payment</option>
            </select>
        </div>

        <!-- Payment Details -->
        <div>
            <label for="card-number">Card Number:</label>
            <input type="text" name="card_number" id="card-number" required pattern="\d{16}" title="Card number must be 16 digits">
        </div>

        <div>
            <label for="cvv">CVV:</label>
            <input type="text" name="cvv" id="cvv" required pattern="\d{3}" title="CVV must be 3 digits">
        </div>

        <div>
            <label for="expiry-month">Expiry Month:</label>
            <select name="expiry_month" id="expiry-month" required>
                <option value="">Month</option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
            </select>

            <label for="expiry-year">Expiry Year:</label>
            <select name="expiry_year" id="expiry-year" required>
                <option value="">Year</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
            </select>
        </div>

        <!-- Submit Payment -->
        <div>
            <button type="submit" name="submit">Submit Payment</button>
        </div>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $paymentMethod = $_POST['payment_method'] ?? '';
        $cardNumber = $_POST['card_number'] ?? '';
        $cvv = $_POST['cvv'] ?? '';
        $expiryMonth = $_POST['expiry_month'] ?? '';
        $expiryYear = $_POST['expiry_year'] ?? '';

        // Validation checks
        $errors = [];

        if (!$paymentMethod) {
            $errors[] = "Payment method is required.";
        }
        if (!preg_match('/^\d{16}$/', $cardNumber)) {
            $errors[] = "Card number must be 16 digits.";
        }
        if (!preg_match('/^\d{3}$/', $cvv)) {
            $errors[] = "CVV must be 3 digits.";
        }
        if (!$expiryMonth || !$expiryYear) {
            $errors[] = "Expiry date is required.";
        }

        if (empty($errors)) {
            // Simulate payment processing (replace with actual payment gateway integration)
            $transactionID = uniqid("PAY-");

            echo "<div style='color: green;'>Payment Successful!<br>Transaction ID: $transactionID</div>";

            // Redirect to application status page (replace with actual URL)
            echo "<script>setTimeout(() => { window.location.href = 'application_status.php'; }, 5000);</script>";
        } else {
            echo "<div style='color: red;'><strong>Errors:</strong><br>" . implode('<br>', $errors) . "</div>";
        }
    }
    ?>
</body>
</html>
