<?php

$base = (strpos($_SERVER['PHP_SELF'], '/pages/') !== false) ? '../' : '';
?>

<div class="nav-bar">
  <a href="<?php echo $base; ?>index.php">Dashboard</a>
  <a href="<?php echo $base; ?>pages/clients_list.php">Clients</a>
  <a href="<?php echo $base; ?>pages/services_list.php">Services</a>
  <a href="<?php echo $base; ?>pages/bookings_list.php">Bookings</a>
  <a href="<?php echo $base; ?>pages/tools_list_assign.php">Tools</a>
  <a href="<?php echo $base; ?>pages/payments_list.php">Payments</a>
</div>
<hr>