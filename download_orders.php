<?php
require 'db_connect.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=all_orders.xls");
header("Pragma: no-cache");
header("Expires: 0");

$query = "SELECT * FROM orders";
$result = mysqli_query($conn, $query);

// Excel Table Header
echo "<table border='1'>";
echo "<tr>
<th>ID</th>
<th>Order UID</th>
<th>Customer Name</th>
<th>Email</th>
<th>Phone</th>
<th>Product Name</th>
<th>Quantity</th>
<th>Address</th>
<th>Order Date</th>
<th>Status</th>
<th>Cancel Reason</th>
<th>Transaction ID</th>
<th>Payment Status</th>
<th>Remarks</th>
</tr>";

// Excel Table Rows
while ($row = mysqli_fetch_assoc($result)) {
  echo "<tr>";
  echo "<td>".$row['id']."</td>";
  echo "<td>".$row['order_uid']."</td>";
  echo "<td>".$row['customer_name']."</td>";
  echo "<td>".$row['email']."</td>";
  echo "<td>".$row['phone']."</td>";
  echo "<td>".$row['product_name']."</td>";
  echo "<td>".$row['quantity']."</td>";
  echo "<td>".$row['address']."</td>";
  echo "<td>".$row['order_date']."</td>";
  echo "<td>".$row['status']."</td>";
  echo "<td>".$row['cancel_reason']."</td>";
  echo "<td>".$row['transaction_id']."</td>";
  echo "<td>".($row['payment_status'] == 1 ? 'Paid' : 'Unpaid')."</td>";
  echo "<td>".$row['cancel_reason']."</td>";
  echo "</tr>";
}

echo "</table>";
?>
