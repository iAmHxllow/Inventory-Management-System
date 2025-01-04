<?php include 'db_config.php'; ?>
<!DOCTYPE html>
<html>

<head>
  <title>Dashboard</title>
  <style>
    /* Add your CSS styles for the grids here */
    .grid-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      grid-gap: 20px;
    }

    .grid-item {
      border: 1px solid #ccc;
      padding: 20px;
      text-align: center;
    }
  </style>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

  <h2>Dashboard</h2>

  <div class="grid-container">
    <div class="grid-item">
      <h3>Total Products</h3>
      <?php
      try {
        $stmt = $conn->query("SELECT COUNT(*) FROM orders");
        $totalProducts = $stmt->fetchColumn();
        echo "<p>" . $totalProducts . "</p>";
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      ?>
    </div>
    <div class="grid-item">
      <h3>Total Order Value</h3>
      <?php
      try {
        $stmt = $conn->query("SELECT SUM(order_value) FROM orders");
        $totalOrderValue = $stmt->fetchColumn();
        echo "<p>€" . number_format($totalOrderValue, 2) . "</p>";
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      ?>
    </div>
    <div class="grid-item">
      <h3>Total Returned</h3>
      <?php
      try {
        $stmt = $conn->query("SELECT COUNT(*) FROM orders WHERE status = 'Returned'");
        $totalReturned = $stmt->fetchColumn();
        echo "<p>" . $totalReturned . "</p>";
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      ?>
    </div>
    <div class="grid-item">
      <h3>Returned Value</h3>
      <?php
      try {
        $stmt = $conn->query("SELECT SUM(order_value) FROM orders WHERE status = 'Returned'");
        $returnedValue = $stmt->fetchColumn();
        echo "<p>€" . number_format($returnedValue, 2) . "</p>";
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      ?>
    </div>
  </div>

  <div class="grid-container">
    <div class="grid-item">
      <h3>Total Quantity</h3>
      <?php
      try {
        $stmt = $conn->query("SELECT SUM(quantity) FROM orders");
        $totalQuantity = $stmt->fetchColumn();
        echo "<p>" . $totalQuantity . "</p>";
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      ?>
    </div>
  </div>

  <div class="grid-container">
    <div class="grid-item">
      <h3>Total Sales</h3>
      <?php
      try {
        $stmt = $conn->query("SELECT COUNT(*) FROM products");
        $totalSales = $stmt->fetchColumn();
        echo "<p>" . $totalSales . "</p>";
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      ?>
    </div>
    <div class="grid-item">
      <h3>Revenue</h3>
      <?php
      try {
        $stmt = $conn->query("SELECT SUM(order_value) FROM products WHERE availability = 'Out of Stock'");
        $revenue = $stmt->fetchColumn();
        echo "<p>€" . number_format($revenue, 2) . "</p>";
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      ?>
    </div>
    <div class="grid-item">
      <h3>Profit</h3>
      <?php
      try {
        $stmt = $conn->query("SELECT SUM(order_value) * 0.40 FROM products");
        $profit = $stmt->fetchColumn();
        echo "<p>€" . number_format($profit, 2) . "</p>";
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      ?>
    </div>
    <div class="grid-item">
      <h3>Total Order Value</h3>
      <?php
      try {
        $stmt = $conn->query("SELECT SUM(order_value) FROM products");
        $totalOrderValue = $stmt->fetchColumn();
        echo "<p>€" . number_format($totalOrderValue, 2) . "</p>";
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      ?>
    </div>
  </div>

  <div class="grid-container">
    <?php
    try {
      // Fetch 3 low quantity products from the database
      $stmt = $conn->query("SELECT * FROM products WHERE quantity < 10 LIMIT 3");
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
        <div class="grid-item">
          <img src="<?php echo $row['image_path']; ?>" alt="<?php echo $row['name']; ?>">
          <h4><?php echo $row['name']; ?></h4>
          <p>Quantity: <?php echo $row['quantity']; ?></p>
          <p>Order Value: €<?php echo number_format($row['order_value'], 2); ?></p>
        </div>
    <?php
      }
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    ?>
  </div>

  <h2>Sales and Purchase Chart</h2>
  <canvas id="salesPurchaseChart"></canvas>

  <h2>Confirmed and Out-for-Delivery Orders Chart</h2>
  <canvas id="ordersChart"></canvas>

  <script>
    // Fetch data for the charts (replace with your actual data fetching logic)
    // ...

    // Example data for the Sales and Purchase chart
    const salesPurchaseData = {
      labels: ['Sales', 'Purchase'],
      datasets: [{
        label: 'Amount',
        data: [1200, 800], // Replace with your actual sales and purchase data
        backgroundColor: [
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 99, 132, 0.2)'
        ],
        borderColor: [
          'rgba(54, 162, 235, 1)',
          'rgba(255, 99, 132, 1)'
        ],
        borderWidth: 1
      }]
    };

    // Example data for the Confirmed and Out-for-Delivery Orders chart
    const ordersData = {
      labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'], // Replace with your actual labels
      datasets: [{
          label: 'Confirmed',
          data: [10, 15, 8, 12], // Replace with your actual confirmed orders data
          borderColor: 'rgba(54, 162, 235, 1)',
          backgroundColor: 'rgba(54, 162, 235, 0.2)',
          fill: false
        },
        {
          label: 'Out for Delivery',
          data: [5, 8, 10, 6], // Replace with your actual out-for-delivery orders data
          borderColor: 'rgba(255, 99, 132, 1)',
          backgroundColor: 'rgba(255, 99, 132, 0.2)',
          fill: false
        }
      ]
    };

    // Chart configuration for the Sales and Purchase chart
    const salesPurchaseConfig = {
      type: 'bar',
      data: salesPurchaseData,
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    };

    // Chart configuration for the Confirmed and Out-for-Delivery Orders chart
    const ordersConfig = {
      type: 'line',
      data: ordersData,
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    };

    // Create the charts
    const salesPurchaseChart = new Chart(
      document.getElementById('salesPurchaseChart'),
      salesPurchaseConfig
    );

    const ordersChart = new Chart(
      document.getElementById('ordersChart'),
      ordersConfig
    );
  </script>

</body>

</html>