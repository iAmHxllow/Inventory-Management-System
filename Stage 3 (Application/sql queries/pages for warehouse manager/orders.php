<?php include 'db_config.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Orders</title>
  <style>
    /* CSS styles for the table, stats grid, popup form, and popup overlay */
    table {
      border-collapse: collapse;
      width: 100%;
    }
    th, td {
      border: 1px solid black;
      padding: 8px;
      text-align: left;
    }
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      grid-gap: 20px;
      margin-bottom: 20px;
    }
    .stat-card {
      border: 1px solid #ccc;
      padding: 20px;
      text-align: center;
    }
    .popup {
      display: none; 
      position: fixed; 
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      border: 1px solid #ccc;
      padding: 20px;
      background-color: white;
      z-index: 100; 
    }
    .popup-overlay {
      display: none; 
      position: fixed; 
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5); 
      z-index: 99; 
    }
  </style>
</head>
<body>

<h2>Orders</h2>

<form action="orders.php" method="get">
  <input type="text" name="search" placeholder="Search orders...">
  <button type="submit">Search</button>
</form>

<h3>Overall Orders</h3> 

<div class="stats-grid">
  <div class="stat-card">
    <h4>Total Orders</h4>
    <?php
    try {
      $stmt = $conn->query("SELECT COUNT(*) FROM orders");
      $totalOrders = $stmt->fetchColumn();
      echo "<p>" . $totalOrders . "</p>";
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    ?>
  </div>
  <div class="stat-card">
    <h4>Total Received</h4>
    <?php
    try {
      $stmt = $conn->query("SELECT COUNT(*), SUM(order_value) FROM orders WHERE status = 'Out for Delivery'");
      $result = $stmt->fetch(PDO::FETCH_NUM);
      $totalReceived = $result[0];
      $totalReceivedValue = $result[1];
      echo "<p>" . $totalReceived . " (€" . number_format($totalReceivedValue, 2) . ")</p>";
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    ?>
  </div>
  <div class="stat-card">
    <h4>Total Returned</h4>
    <?php
    try {
      $stmt = $conn->query("SELECT COUNT(*), SUM(order_value) FROM orders WHERE status = 'Returned'");
      $result = $stmt->fetch(PDO::FETCH_NUM);
      $totalReturned = $result[0];
      $totalReturnedValue = $result[1];
      echo "<p>" . $totalReturned . " (€" . number_format($totalReturnedValue, 2) . ")</p>";
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    ?>
  </div>
  <div class="stat-card">
    <h4>On the Way</h4>
    <?php
    try {
      $stmt = $conn->query("SELECT COUNT(*), SUM(order_value) FROM orders WHERE status = 'Delayed'");
      $result = $stmt->fetch(PDO::FETCH_NUM);
      $totalOnTheWay = $result[0];
      $totalOnTheWayValue = $result[1];
      echo "<p>" . $totalOnTheWay . " (€" . number_format($totalOnTheWayValue, 2) . ")</p>";
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    ?>
  </div>
</div>

<button id="addOrderBtn">Add Order</button>
<button id="filterBtn">Filter</button> 
<button id="ordersHistoryBtn">Orders History</button> 

<div id="filterOptions" style="display: none;">
  <label for="filterQuantity">Quantity:</label>
  <select id="filterQuantity">
    <option value="">Select</option>
    <option value="asc">Lowest to Highest</option>
    <option value="desc">Highest to Lowest</option>
  </select><br><br>
  <label for="filterOrderValue">Order Value:</label>
  <select id="filterOrderValue">
    <option value="">Select</option>
    <option value="asc">Lowest to Highest</option>
    <option value="desc">Highest to Lowest</option>
  </select><br><br>
  <button onclick="applyFilters()">Apply Filters</button>
</div>

<div class="popup-overlay" id="popupOverlay"></div>
<div class="popup" id="addOrderPopup">
  <form id="addOrderForm" action="orders.php" method="post"> 
    <label for="product_name">Product Name:</label>
    <input type="text" id="product_name" name="product_name" required><br><br>
    <label for="order_value">Order Value:</label>
    <input type="number" id="order_value" name="order_value" step="0.01" required><br><br>
    <label for="quantity">Quantity:</label>
    <input type="number" id="quantity" name="quantity" required><br><br>
    <label for="order_id">Order ID:</label>
    <input type="text" id="order_id" name="order_id" required><br><br>
    <label for="expected_delivery">Expected Delivery:</label>
    <input type="date" id="expected_delivery" name="expected_delivery" required><br><br>
    <input type="submit" value="Add Order"> 
  </form>
  <button onclick="closePopup()">Close</button> 
</div>


<table>
  <thead>
    <tr>
      <th>Product</th>
      <th>Order Value</th>
      <th>Quantity</th>
      <th>Order ID</th>
      <th>Expected Delivery</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody id="orderTableBody">
    <?php
    try {
      if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $stmt = $conn->prepare("SELECT * FROM orders WHERE product_name LIKE :search OR order_id LIKE :search");
        $stmt->bindValue(':search', '%' . $search . '%');
        $stmt->execute();
      } else {
        $stmt = $conn->query("SELECT * FROM orders");
      }

      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Determine status based on quantity
        if ($row['quantity'] > 30) {
          $status = "Delayed";
        } elseif ($row['quantity'] > 20) {
          $status = "Confirmed";
        } elseif ($row['quantity'] > 10) {
          $status = "Out for Delivery";
        } else {
          $status = "Returned";
        }

        echo "<tr>";
        echo "<td>" . $row['product_name'] . "</td>"; 
        echo "<td>" . $row['order_value'] . "</td>"; 
        echo "<td>" . $row['quantity'] . "</td>";
        echo "<td>" . $row['order_id'] . "</td>"; 
        echo "<td>" . $row['expected_delivery'] . "</td>"; 
        echo "<td>" . $status . "</td>";
        echo "</tr>";
      }
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    $conn = null;
    ?>
  </tbody>
</table>

<script>
  // ... (JavaScript for search functionality) ...

  const addOrderBtn = document.getElementById('addOrderBtn');
  const addOrderPopup = document.getElementById('addOrderPopup');
  const popupOverlay = document.getElementById('popupOverlay');
  const addOrderForm = document.getElementById('addOrderForm'); 
  const orderTableBody = document.getElementById('orderTableBody'); 

  addOrderBtn.addEventListener('click', () => {
    addOrderPopup.style.display = 'block';
    popupOverlay.style.display = 'block';
  });

  function closePopup() {
    addOrderPopup.style.display = 'none';
    popupOverlay.style.display = 'none';
  }

  const filterBtn = document.getElementById('filterBtn');
  const filterOptions = document.getElementById('filterOptions');

  filterBtn.addEventListener('click', () => {
    if (filterOptions.style.display === 'none') {
      filterOptions.style.display = 'block';
    } else {
      filterOptions.style.display = 'none';
    }
  });

  function applyFilters() {
    // ... (JavaScript for filtering functionality) ...
  }

  // Add an event listener for form submission
  addOrderForm.addEventListener('submit', (event) => {
    event.preventDefault(); 

    const formData = new FormData(addOrderForm);

    fetch('orders.php', { 
        method: 'POST',
        body: formData
      })
      .then(response => response.text())
      .then(data => {
        console.log(data); 
        closePopup(); 
      })
      .catch(error => console.error('Error adding order:', error));
  });

  // Function to show orders history
  function showOrdersHistory() {
    fetch('orders_history.php') 
      .then(response => response.text())
      .then(html => {
        orderTableBody.innerHTML = html; 
      })
      .catch(error => console.error('Error fetching orders history:', error));
  }

  const ordersHistoryBtn = document.getElementById('ordersHistoryBtn');
  ordersHistoryBtn.addEventListener('click', showOrdersHistory);
</script>

</body>
</html>