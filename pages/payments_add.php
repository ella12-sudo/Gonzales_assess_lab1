<?php
include "../db.php";

// Fetch bookings (only show bookings)
$bookings = mysqli_query($conn, "
    SELECT b.booking_id, c.full_name, b.total_cost 
    FROM bookings b
    JOIN clients c ON b.client_id = c.client_id
    ORDER BY b.booking_id DESC
");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $booking_id = $_POST['booking_id'];
    $amount_paid = $_POST['amount_paid'];
    $method = $_POST['method'];

    $sql = "INSERT INTO payments (booking_id, amount_paid, method)
            VALUES ($booking_id, $amount_paid, '$method')";

    if (mysqli_query($conn, $sql)) {
        header("Location: payments_list.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!doctype html>
<html>
<head>
    <title>Add Payment</title>
</head>
<link rel="stylesheet" href="../style.css">
<body>

<?php include "../nav.php"; ?>

<h2>Add Payment</h2>

<form method="POST">

    <p>
        <label>Booking:</label><br>
        <select name="booking_id" required>
            <option value="">Select Booking</option>
            <?php while($b = mysqli_fetch_assoc($bookings)): ?>
                <option value="<?php echo $b['booking_id']; ?>">
                    Booking #<?php echo $b['booking_id']; ?> - 
                    <?php echo $b['full_name']; ?> 
                    (₱<?php echo number_format($b['total_cost'],2); ?>)
                </option>
            <?php endwhile; ?>
        </select>
    </p>

    <p>
        <label>Amount Paid:</label><br>
        <input type="number" name="amount_paid" step="0.01" required>
    </p>

    <p>
        <label>Payment Method:</label><br>
        <select name="method">
            <option value="CASH">Cash</option>
            <option value="GCASH">GCash</option>
            <option value="BANK">Bank Transfer</option>
        </select>
    </p>

    <p>
        <button type="submit">Record Payment</button>
    </p>

</form>

<p>
    <a href="payments_list.php">Back to Payments</a>
</p>

</body>
</html>