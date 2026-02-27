<?php
// Show errors instead of blank screen
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Use the same DB include as other pages
include "../db.php";

// Validate booking_id from GET
if (!isset($_GET['booking_id']) || !is_numeric($_GET['booking_id'])) {
    die("Invalid booking ID.");
}
$booking_id = (int)$_GET['booking_id'];

// Fetch booking details
$booking = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM bookings WHERE booking_id=$booking_id"));
if (!$booking) {
    die("Booking not found.");
}

// Use the correct column name from your DB (confirmed: total_cost)
$total_cost = $booking['total_cost'];

// Get total paid so far
$paidRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS paid FROM payments WHERE booking_id=$booking_id"));
$total_paid = $paidRow['paid'];

// Compute balance
$balance = $total_cost - $total_paid;
$message = "";

// Handle payment submission
if (isset($_POST['pay'])) {
    $amount = $_POST['amount_paid'];
    $method = $_POST['method'];

    if ($amount <= 0) {
        $message = "Invalid amount!";
    } else if ($amount > $balance) {
        $message = "Amount exceeds balance!";
    } else {
        // Insert payment
        mysqli_query($conn, "INSERT INTO payments (booking_id, amount_paid, method) VALUES ($booking_id, $amount, '$method')");

        // Recompute totals
        $paidRow2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS paid FROM payments WHERE booking_id=$booking_id"));
        $total_paid2 = $paidRow2['paid'];
        $new_balance = $total_cost - $total_paid2;

        // If fully paid, update booking status
        if ($new_balance <= 0.009) {
            mysqli_query($conn, "UPDATE bookings SET status='PAID' WHERE booking_id=$booking_id");
        }

        // Redirect back to bookings list
        header("Location: bookings_list.php");
        exit;
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Process Payment</title>
</head>
<body>
<?php include "../nav.php"; ?>

<h2>Process Payment (Booking #<?php echo $booking_id; ?>)</h2>

<p>Total Cost: ₱<?php echo number_format($total_cost, 2); ?></p>
<p>Total Paid: ₱<?php echo number_format($total_paid, 2); ?></p>
<p><b>Balance: ₱<?php echo number_format($balance, 2); ?></b></p>

<p style="color:red;"><?php echo $message; ?></p>

<form method="post">
    <label>Amount Paid</label><br>
    <input type="number" name="amount_paid" step="0.01" required><br><br>

    <label>Method</label><br>
    <select name="method" required>
        <option value="CASH">CASH</option>
        <option value="GCASH">GCASH</option>
        <option value="CARD">CARD</option>
    </select><br><br>

    <button type="submit" name="pay">Save Payment</button>
</form>

</body>
</html>
