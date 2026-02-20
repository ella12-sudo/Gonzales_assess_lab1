<?php
include "../db.php"; // connect to database

// Fetch all clients with error handling
$clientsResult = mysqli_query($conn, "SELECT * FROM clients ORDER BY client_id DESC");

if (!$clientsResult) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!doctype html>
<html>
<head>
    <link rel="stylesheet" href="../style.css">
    
    <meta charset="utf-8">
    <title>Clients List</title>
</head>
<body>

<?php include "../nav.php"; ?>

<h2>Clients List</h2>

<p>
    <a href="clients_add.php">Add New Client</a>
</p>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Created At</th>
        <th>Actions</th>
    </tr>

    <?php if (mysqli_num_rows($clientsResult) > 0): ?>
        <?php while($row = mysqli_fetch_assoc($clientsResult)): ?>
        <tr>
            <td><?php echo $row['client_id']; ?></td>
            <td><?php echo $row['full_name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['address']; ?></td>
            <td><?php echo $row['created_at']; ?></td>
            <td>
                <a href="clients_edit.php?id=<?php echo $row['client_id']; ?>">Edit</a> |
                <a href="clients_delete.php?id=<?php echo $row['client_id']; ?>" 
                   onclick="return confirm('Are you sure you want to delete this client?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="7">No clients found.</td>
        </tr>
    <?php endif; ?>
</table>

</body>
</html>
