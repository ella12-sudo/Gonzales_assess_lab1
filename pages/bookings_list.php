<?php
include "../db.php";

$sql = "SELECT b.*, c.full_name, s.service_name 
        FROM bookings b
        JOIN clients c ON b.client_id = c.client_id
        JOIN services s ON b.service_id = s.service_id
        ORDER BY b.booking_id DESC";

$result = mysqli_query($conn, $sql);
?>

<!doctype html>
<html>
<head>
    <link rel="stylesheet" href="../style.css">
    
    <title>Bookings List</title>
</head>
<body>

<?php include "../nav.php"; ?>

<h2>Bookings List</h2>

<table border="1" cellpadding="8">
<tr>
    <th>ID</th>
    <th>Client</th>
    <th>Service</th>
    <th>Date</th>
    <th>Hours</th>
    <th>Total Cost</th>
    <th>Status</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?php echo $row['booking_id']; ?></td>
    <td><?php echo $row['full_name']; ?></td>
    <td><?php echo $row['service_name']; ?></td>
    <td><?php echo $row['booking_date']; ?></td>
    <td><?php echo $row['hours']; ?></td>
    <td>₱<?php echo number_format($row['total_cost'],2); ?></td>
    <td><?php echo $row['status']; ?></td>
</tr>
<?php endwhile; ?>

</table>

</body>
</html>