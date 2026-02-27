<?php
include "../db.php";

$booking_id = isset($_GET['booking_id']) ? (int)$_GET['booking_id'] : 0;

// Default values (so page never crashes)
$total_cost = 0;
$total_paid = 0;
$balance = 0;
$message = "";

// Get booking
$result = mysqli_query($conn, "SELECT * FROM bookings WHERE booking_id=$booking_id");

if ($result && mysqli_num_rows($result) > 0) {

    $booking = mysqli_fetch_assoc($result);
    $total_cost = $booking['total_cost'];

    // Get total paid
    $paidRow = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS paid FROM payments WHERE booking_id=$booking_id")
    );

    $total_paid = $paidRow['paid'];
    $balance = $total_cost - $total_paid;

} else {
    $message = "Booking not found.";
}


// PROCESS PAYMENT
if (isset($_POST['pay'])) {

    $amount = $_POST['amount_paid'];
    $method = $_POST['method'];

    if ($amount <= 0) {
        $message = "Invalid amount!";
    } 
    else if ($amount > $balance) {
        $message = "Amount exceeds balance!";
    } 
    else {

        // Insert payment
        mysqli_query($conn, 
            "INSERT INTO payments (booking_id, amount_paid, method)
             VALUES ($booking_id, $amount, '$method')"
        );

        // Recompute total paid
        $paidRow2 = mysqli_fetch_assoc(
            mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS paid FROM payments WHERE booking_id=$booking_id")
        );

        $total_paid2 = $paidRow2['paid'];
        $new_balance = $total_cost - $total_paid2;

        // If fully paid → update status
        if ($new_balance <= 0.009) {
            mysqli_query($conn, 
                "UPDATE bookings SET status='PAID' WHERE booking_id=$booking_id"
            );
        }

        header("Location: bookings_list.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Process Payment</title>
    <link rel="stylesheet" href="../dashboard_style.css">
</head>
<body>

<div class="dashboard-container">

    <h2>Process Payment (Booking #<?php echo $booking_id; ?>)</h2>

    <div class="form-container">
        <form method="POST">

            <div class="payment-summary">
                <p><strong>Total Cost:</strong> ₱<?php echo number_format($total_cost,2); ?></p>
                <p><strong>Total Paid:</strong> ₱<?php echo number_format($total_paid,2); ?></p>
                <p class="balance">
                    <strong>Balance:</strong> ₱<?php echo number_format($balance,2); ?>
                </p>
            </div>

            <p style="color:red;"><?php echo $message; ?></p>

            <label>Amount Paid</label>
            <input type="number" name="amount_paid" step="0.01" required>

            <label>Payment Method</label>
            <select name="method" required>
                <option value="CASH">Cash</option>
                <option value="GCASH">GCash</option>
                <option value="CARD">Card</option>
            </select>

            <button type="submit" name="pay">Save Payment</button>

        </form>
    </div>

</div>

</body>
</html>
 