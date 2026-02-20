<?php
include "../db.php";

if (!isset($_GET['id'])) {
    die("Client ID not specified.");
}

$id = intval($_GET['id']);

$sql = "DELETE FROM clients WHERE client_id = $id";

if (mysqli_query($conn, $sql)) {
    header("Location: clients_list.php"); // redirect back to list
    exit;
} else {
    die("Error deleting client: " . mysqli_error($conn));
}
?>
