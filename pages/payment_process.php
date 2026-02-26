<?php
include '../db.php';

$booking_id = $_GET['booking_id'];
?>

<h2>Process Payment</h2>

<form method="POST">
    <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">

    <label>Payment Method:</label>
    <select name="payment_method" required>
        <option value="">Select Method</option>
        <option value="GCash">GCash</option>
        <option value="Card">Card</option>
        <option value="Cash">Cash</option>
    </select>

    <br><br>
    <button type="submit" name="pay">Confirm Payment</button>
</form>

<?php
if (isset($_POST['pay'])) {
    $booking_id = $_POST['booking_id'];
    $method = $_POST['payment_method'];

    $update = "UPDATE bookings 
               SET status='PAID' 
               WHERE booking_id='$booking_id'";

    mysqli_query($conn, $update);

    header("Location: bookings_list.php");
}
?>