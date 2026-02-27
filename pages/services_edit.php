<?php
include "../db.php";
$id = $_GET['id'];
 
$get = mysqli_query($conn, "SELECT * FROM services WHERE service_id = $id");
$service = mysqli_fetch_assoc($get);
 
if (isset($_POST['update'])) {
  $name = $_POST['service_name'];
  $desc = $_POST['description'];
  $rate = $_POST['hourly_rate'];
  $active = $_POST['is_active'];
 
  mysqli_query($conn, "UPDATE services
    SET service_name='$name', description='$desc', hourly_rate='$rate', is_active='$active'
    WHERE service_id=$id");
 
  header("Location: services_list.php");
  exit;
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Service</title>
  <link rel="stylesheet" href="../dashboard_style.css">

  <style>
    .form-container {
      max-width: 500px;
      margin: 40px auto;
      padding: 35px;
      background: #ffffff;
      border-radius: 16px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    }

    .form-container label {
      display: block;
      margin-bottom: 6px;
      font-weight: 600;
      font-size: 14px;
    }

    .form-container input,
    .form-container textarea,
    .form-container select {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-size: 14px;
      margin-bottom: 18px;
      box-sizing: border-box;
    }

    .form-container textarea {
      resize: vertical;
      min-height: 90px;
    }

    .form-container button {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 10px;
      font-size: 15px;
      font-weight: 600;
      color: white;
      background: linear-gradient(to right, #5f6de0, #7b4de0);
      cursor: pointer;
    }
  </style>
</head>
<body>
<?php include "../nav.php"; ?>
 
<h2>Edit Service</h2>
 
<form method="post">
  <label>Service Name</label><br>
  <input type="text" name="service_name" value="<?php echo $service['service_name']; ?>"><br><br>
 
  <label>Description</label><br>
  <textarea name="description" rows="4" cols="40"><?php echo $service['description']; ?></textarea><br><br>
 
  <label>Hourly Rate</label><br>
  <input type="text" name="hourly_rate" value="<?php echo $service['hourly_rate']; ?>"><br><br>
 
  <label>Active</label><br>
  <select name="is_active">
    <option value="1" <?php if($service['is_active']==1) echo "selected"; ?>>Yes</option>
    <option value="0" <?php if($service['is_active']==0) echo "selected"; ?>>No</option>
  </select><br><br>
 
  <button type="submit" name="update">Update</button>
</form>
</body>
</html>