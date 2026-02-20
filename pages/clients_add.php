<?php
include "../db.php"; // connect to database

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $sql = "INSERT INTO clients (full_name, email, phone, address) 
            VALUES ('$full_name', '$email', '$phone', '$address')";

    if (mysqli_query($conn, $sql)) {
        echo "<p style='color:green;'>Client added successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!doctype html>
<html>
<head>
    <link rel="stylesheet" href="../style.css">
    <meta charset="utf-8">
    <title>Add New Client</title>
</head>
<body>

<?php include "../nav.php"; ?>

<h2>Add New Client</h2>

<form method="POST">
    <p>
        <label>Full Name:</label><br>
        <input type="text" name="full_name" required>
    </p>
    <p>
        <label>Email:</label><br>
        <input type="email" name="email" required>
    </p>
    <p>
        <label>Phone:</label><br>
        <input type="text" name="phone">
    </p>
    <p>
        <label>Address:</label><br>
        <input type="text" name="address">
    </p>
    <p>
        <button type="submit">Add Client</button>
    </p>
</form>

<p>
    <a href="clients_list.php">Back to Clients List</a>
</p>

</body>
</html>
