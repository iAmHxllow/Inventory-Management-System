<?php include 'db_config.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Low Quantity Products</title>
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
    }
    th, td {
      border: 1px solid black;
      padding: 8px;
      text-align: left;
    }
    img {
      max-width: 100px;
      max-height: 100px;
    }
  </style>
</head>
<body>

<h2>Low Quantity Products</h2>

<table>
  <tr>
    <th>Image</th>
    <th>Name</th>
    <th>Product ID</th>
    <th>Category</th>
    <th>Buying Price</th>
    <th>Quantity</th>
    <th>Unit</th>
    <th>Expiry Date</th>
    <th>Threshold Value</th>
  </tr>
  <?php
  try {
    $stmt = $conn->query("SELECT * FROM products WHERE quantity < 10"); 
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>";
      echo "<td><img src='" . $row['image_path'] . "' alt='" . $row['name'] . "'></td>";
      echo "<td>" . $row['name'] . "</td>";
      echo "<td>" . $row['product_id'] . "</td>";
      echo "<td>" . $row['category'] . "</td>";
      echo "<td>" . $row['buying_price'] . "</td>";
      echo "<td>" . $row['quantity'] . "</td>";
      echo "<td>" . $row['unit'] . "</td>";
      echo "<td>" . $row['expiry_date'] . "</td>";
      echo "<td>" . $row['threshold_value'] . "</td>";
      echo "</tr>";
    }
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
  ?>
</table>

</body>
</html>