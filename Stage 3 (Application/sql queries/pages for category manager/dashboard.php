<?php include 'db_config.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <style>
    /* Add your CSS styles here */
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

<h2>Dashboard</h2>

<form action="dashboard.php" method="get">
  <input type="text" name="search" placeholder="Search products...">
  <button type="submit">Search</button>
</form>

<h3>Low Quantity Products</h3>
<table>
  <thead>
    <tr>
      <th>Image</th>
      <th>Name</th>
      <th>Quantity</th>
      <th>Availability</th>
    </tr>
  </thead>
  <tbody>
    <?php
    try {
      if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE :search AND quantity < 10");
        $stmt->bindValue(':search', '%' . $search . '%');
        $stmt->execute();
      } else {
        $stmt = $conn->query("SELECT * FROM products WHERE quantity < 10");
      }

      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td><img src='" . $row['image_path'] . "' alt='" . $row['name'] . "'></td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['quantity'] . "</td>";
        echo "<td>" . $row['availability'] . "</td>";
        echo "</tr>";
      }
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    ?>
  </tbody>
</table>

<h3>Top Selling Stock</h3>
<table>
  <thead>
    <tr>
      <th>Image</th>
      <th>Name</th>
      <th>Quantity</th>
      <th>Availability</th>
    </tr>
  </thead>
  <tbody>
    <?php
    try {
      if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE :search AND quantity > 20");
        $stmt->bindValue(':search', '%' . $search . '%');
        $stmt->execute();
      } else {
        $stmt = $conn->query("SELECT * FROM products WHERE quantity > 20");
      }

      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td><img src='" . $row['image_path'] . "' alt='" . $row['name'] . "'></td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['quantity'] . "</td>";
        echo "<td>" . $row['availability'] . "</td>";
        echo "</tr>";
      }
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    $conn = null;
    ?>
  </tbody>
</table>

</body>
</html>