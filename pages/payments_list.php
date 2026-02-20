<?php
include "../db.php";

$sql = "SELECT p.*, b.booking_id, c.full_name
        FROM payments p
        JOIN bookings b ON p.booking_id = b.booking_id
        JOIN clients c ON b.client_id = c.client_id
        ORDER BY p.payment_id DESC";

$result = mysqli_query($conn, $sql);
?>

<!doctype html>
<html>
<head>
    <title>Payments List</title>
</head>
<link rel="stylesheet" href="../style.css">
<body>

<?php include "../nav.php"; ?>

<h2>Payments List</h2>

<table border="1" cellpadding="8">
<tr>
    <th>ID</th>
    <th>Booking ID</th>
    <th>Client</th>
    <th>Amount Paid</th>
    <th>Method</th>
    <th>Date</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?php echo $row['payment_id']; ?></td>
    <td><?php echo $row['booking_id']; ?></td>
    <td><?php echo $row['full_name']; ?></td>
    <td>₱<?php echo number_format($row['amount_paid'],2); ?></td>
    <td><?php echo $row['method']; ?></td>
    <td><?php echo $row['payment_date']; ?></td>
</tr>
<?php endwhile; ?>

</table>

</body>
</html>