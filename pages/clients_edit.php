<?php
include "../db.php";

if (!isset($_GET['id'])) {
    die("Client ID not specified.");
}

$id = intval($_GET['id']);

// Fetch existing client
$result = mysqli_query($conn, "SELECT * FROM clients WHERE client_id = $id");
$client = mysqli_fetch_assoc($result);

if (!$client) {
    die("Client not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $sql = "UPDATE clients SET 
            full_name='$full_name', 
            email='$email', 
            phone='$phone', 
            address='$address' 
            WHERE client_id=$id";

    if (mysqli_query($conn, $sql)) {
        echo "<p style='color:green;'>Client updated successfully!</p>";
        $client = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM clients WHERE client_id = $id"));
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
    <title>Edit Client</title>
</head>
<body>

<?php include "../nav.php"; ?>

<h2>Edit Client</h2>

<form method="POST">
    <p>
        <label>Full Name:</label><br>
        <input type="text" name="full_name" value="<?php echo $client['full_name']; ?>" required>
    </p>
    <p>
        <label>Email:</label><br>
        <input type="email" name="email" value="<?php echo $client['email']; ?>" required>
    </p>
    <p>
        <label>Phone:</label><br>
        <input type="text" name="phone" value="<?php echo $client['phone']; ?>">
    </p>
    <p>
        <label>Address:</label><br>
        <input type="text" name="address" value="<?php echo $client['address']; ?>">
    </p>
    <p>
        <button type="submit">Update Client</button>
    </p>
</form>

<p>
    <a href="clients_list.php">Back to Clients List</a>
</p>

</body>
</html>
