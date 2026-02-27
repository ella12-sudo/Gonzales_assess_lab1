<?php
include "../db.php";

/* ============================
   SOFT DELETE (Deactivate)
   ============================ */
if (isset($_GET['delete_id'])) {
  $delete_id = $_GET['delete_id'];
  mysqli_query($conn, "UPDATE services SET is_active=0 WHERE service_id=$delete_id");
  header("Location: services_list.php");
  exit;
}

/* ============================
   FETCH ALL SERVICES
   ============================ */
$result = mysqli_query($conn, "SELECT * FROM services ORDER BY service_id DESC");
?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Services</title>
  <link rel="stylesheet" href="../dashboard_style.css">
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 10px 15px;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
      font-weight: 600;
      border-bottom: 2px solid #ddd;
    }
    td {
      border-bottom: 1px solid #eee;
    }
    tr:hover {
      background-color: #f9f9f9;
    }
    .add-button {
      display: inline-block;
      margin-bottom: 15px;
      padding: 10px 16px;
      background: linear-gradient(to right, #5f6de0, #7b4de0);
      color: white;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
    }
  </style>
</head>
<body>
<?php include "../nav.php"; ?>

<div class="dashboard-container">

  <h2>Services</h2>

  <a href="services_add.php" class="add-button">+ Add Service</a>

  <table>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Rate</th>
      <th>Status</th>
      <th>Action</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td><?php echo $row['service_id']; ?></td>
        <td><?php echo $row['service_name']; ?></td>
        <td>₱<?php echo number_format($row['hourly_rate'],2); ?></td>
        <td><?php echo ($row['is_active'] == 1) ? "Active" : "Inactive"; ?></td>
        <td>
          <a href="services_edit.php?id=<?php echo $row['service_id']; ?>">Edit</a>
          <?php if ($row['is_active'] == 1) { ?>
            | <a href="services_list.php?delete_id=<?php echo $row['service_id']; ?>"
                 onclick="return confirm('Deactivate this service?')">Deactivate</a>
          <?php } ?>
        </td>
      </tr>
    <?php } ?>

  </table>

</div>
</body>
</html>