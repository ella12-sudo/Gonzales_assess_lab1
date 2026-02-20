<?php
include "../db.php";

// Fetch clients
$clients = mysqli_query($conn, "SELECT * FROM clients");

// Fetch services
$services = mysqli_query($conn, "SELECT * FROM services WHERE is_active = 1");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $client_id = $_POST['client_id'];
    $service_id = $_POST['service_id'];
    $booking_date = $_POST['booking_date'];
    $hours = $_POST['hours'];

    // Get service hourly rate
    $serviceQuery = mysqli_query($conn, "SELECT hourly_rate FROM services WHERE service_id = $service_id");
    $service = mysqli_fetch_assoc($serviceQuery);

    $hourly_rate_snapshot = $service['hourly_rate'];
    $total_cost = $hours * $hourly_rate_snapshot;

    $sql = "INSERT INTO bookings 
            (client_id, service_id, booking_date, hours, hourly_rate_snapshot, total_cost, status)
            VALUES 
            ($client_id, $service_id, '$booking_date', $hours, $hourly_rate_snapshot, $total_cost, 'PENDING')";

    if (mysqli_query($conn, $sql)) {
        header("Location: bookings_list.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!doctype html>
<html>
<head>
    <title>Create Booking</title>
</head>
<link rel="stylesheet" href="../style.css">

<body>

<?php include "../nav.php"; ?>

<h2>Create Booking</h2>

<form method="POST">

    <p>
        <label>Client:</label><br>
        <select name="client_id" required>
            <option value="">Select Client</option>
            <?php while($c = mysqli_fetch_assoc($clients)): ?>
                <option value="<?php echo $c['client_id']; ?>">
                    <?php echo $c['full_name']; ?>
                </option>
            <?php endwhile; ?>
        </select>
    </p>

    <p>
        <label>Service:</label><br>
        <select name="service_id" required>
            <option value="">Select Service</option>
            <?php while($s = mysqli_fetch_assoc($services)): ?>
                <option value="<?php echo $s['service_id']; ?>">
                    <?php echo $s['service_name']; ?> (₱<?php echo $s['hourly_rate']; ?>/hr)
                </option>
            <?php endwhile; ?>
        </select>
    </p>

    <p>
        <label>Booking Date:</label><br>
        <input type="date" name="booking_date" required>
    </p>

    <p>
        <label>Hours:</label><br>
        <input type="number" name="hours" min="1" value="1" required>
    </p>

    <p>
        <button type="submit">Create Booking</button>
    </p>

</form>

<p>
    <a href="bookings_list.php">Back to Bookings</a>
</p>

</body>
</html>