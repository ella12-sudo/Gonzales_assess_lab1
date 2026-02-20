<?php
include "../db.php";

$result = mysqli_query($conn, "SELECT * FROM services ORDER BY service_id DESC");
?>

<!doctype html>
<html>
<head>
    <title>Services List</title>
</head>
<link rel="stylesheet" href="../style.css">
<body>

<?php include "../nav.php"; ?>

<h2>Services List</h2>

<table border="1" cellpadding="8">
<tr>
    <th>ID</th>
    <th>Service Name</th>
    <th>Description</th>
    <th>Hourly Rate</th>
    <th>Status</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?php echo $row['service_id']; ?></td>
    <td><?php echo $row['service_name']; ?></td>
    <td><?php echo $row['description']; ?></td>
    <td>₱<?php echo number_format($row['hourly_rate'],2); ?></td>
    <td><?php echo $row['is_active'] ? 'Active' : 'Inactive'; ?></td>
</tr>
<?php endwhile; ?>

</table>

</body>
</html>