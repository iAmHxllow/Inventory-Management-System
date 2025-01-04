<?php include 'db_config.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Reports</title>
  <style>
    .overview-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
      grid-gap: 20px;
      margin-bottom: 20px; 
    }
    .overview-card {
      border: 1px solid #ccc;
      padding: 20px;
      text-align: center;
    }
  </style>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<h2>Reports</h2>

<div class="overview-grid">
  <div class="overview-card">
    <h3>Total Profit</h3>
    <?php
    try {
      $stmt = $conn->query("SELECT SUM(order_value * quantity) * 0.10 FROM products");
      $totalProfit = $stmt->fetchColumn();
      echo "<p>€" . number_format($totalProfit, 2) . "</p>"; 
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    ?>
  </div>
  <div class="overview-card">
    <h3>Revenue</h3>
    <?php
    try {
      $stmt = $conn->query("SELECT SUM(order_value * quantity) / 12 FROM products");
      $revenue = $stmt->fetchColumn();
      echo "<p>€" . number_format($revenue, 2) . "</p>";
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    ?>
  </div>
  <div class="overview-card">
    <h3>Sales</h3>
    <?php
    try {
      // Note: This assumes you have a way to track individual sales quantities
      // You might need to adjust the query based on your actual sales data
      $stmt = $conn->query("SELECT SUM(quantity) / 12 FROM products"); 
      $sales = $stmt->fetchColumn();
      echo "<p>" . number_format($sales, 2) . "</p>"; 
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    ?>
  </div>
  <div class="overview-card">
    <h3>Net Purchase Value</h3>
    <?php
    try {
      $stmt = $conn->query("SELECT SUM(order_value) FROM products");
      $netPurchaseValue = $stmt->fetchColumn();
      echo "<p>€" . number_format($netPurchaseValue, 2) . "</p>";
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    ?>
  </div>
  <div class="overview-card">
    <h3>Net Sales Value</h3>
    <?php
    try {
      $stmt = $conn->query("SELECT SUM(order_value) * 12 FROM products");
      $netSalesValue = $stmt->fetchColumn();
      echo "<p>€" . number_format($netSalesValue, 2) . "</p>";
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    ?>
  </div>
  <div class="overview-card">
    <h3>Month-over-Month Profit</h3>
    <?php
    try {
      $stmt = $conn->query("SELECT (SUM(order_value * quantity) * 0.10) + (SUM(order_value * quantity) / 12) FROM products");
      $monthOverMonthProfit = $stmt->fetchColumn();
      echo "<p>€" . number_format($monthOverMonthProfit, 2) . "</p>";
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    ?>
  </div>
</div>

<h2>Revenue and Profit Chart</h2>
<canvas id="revenueProfitChart"></canvas> 

<script>
  // Get the revenue and profit values from the overview cards
  const totalProfitElement = document.querySelector('.overview-card:nth-child(1) p'); 
  const revenueElement = document.querySelector('.overview-card:nth-child(2) p'); 

  // Extract the numeric values from the text content
  const totalProfit = parseFloat(totalProfitElement.textContent.replace(/[€ ,]/g, '')); 
  const revenue = parseFloat(revenueElement.textContent.replace(/[€ ,]/g, '')); 

  const data = {
    labels: ['Total Profit', 'Revenue'],
    datasets: [{
      label: 'Amount (€)',
      data: [totalProfit, revenue],
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)'
      ],
      borderColor: [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)'
      ],
      borderWidth: 1,
      tension: 0.4 
    }]
  };

  // Chart configuration 
  const config = {
    type: 'line',  
    data: data,
    options: {
      scales: {
        y: {
          beginAtZero: true 
        }
      }
    }
  };

  // Create the chart
  const revenueProfitChart = new Chart(
    document.getElementById('revenueProfitChart'),
    config
  );
</script>

</body>
</html>