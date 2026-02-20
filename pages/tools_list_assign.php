<?php
include "../db.php";

$result = mysqli_query($conn, "SELECT * FROM tools ORDER BY tool_id DESC");
?>

<!doctype html>
<html>
<head>
    <title>Tools List</title>
</head>
<link rel="stylesheet" href="../style.css">
<body>

<?php include "../nav.php"; ?>

<h2>Tools List</h2>

<table border="1" cellpadding="8">
<tr>
    <th>ID</th>
    <th>Tool Name</th>
    <th>Total Quantity</th>
    <th>Available</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?php echo $row['tool_id']; ?></td>
    <td><?php echo $row['tool_name']; ?></td>
    <td><?php echo $row['quantity_total']; ?></td>
    <td><?php echo $row['quantity_available']; ?></td>
</tr>
<?php endwhile; ?>

</table>

</body>
</html>